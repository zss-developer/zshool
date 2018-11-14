<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Publication;
use App\Models\StorageSection;
use App\Models\Subject;
use App\Models\TemporaryStore;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use ZipArchive;

class StorageController extends Controller
{

    /**
     * StorageController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
    }

    public function storageIndex(Request $request, $code)
    {
        $section  = StorageSection::where('code', $code)->firstOrFail();
        $subjects = Subject::all();

        $publications = Publication::where('section_id', $section->id)
            ->orderByDesc('created_at')
            ->with('author')
            ->paginate(config('settings.storage.publications_per_page'));


        return response()->view('pages.frontend.storage.index', [
            'section'       => $section,
            'subjects'      => $subjects,
            'publications'  => $publications,
        ]);
    }

    public function storageView(Request $request,$code, $id)
    {
        $section  = StorageSection::where('code', $code)->firstOrFail();
        $publication = Publication::where('id', $id)->with('author')->firstOrFail();

        return response()->view('pages.frontend.storage.view', [
            'section'       => $section,
            'publication'  => $publication,
        ]);

    }

    public function storageUpload(Request $request)
    {
        $subjects = Subject::all();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'title'        => 'required|string|max:191',
                'section'       => 'required|exists:storage_sections,id',
                'subject'       => 'required|exists:subjects,id',
                'class'         => 'required|numeric|between:0,11',
                'description'   => 'nullable',
                'files'         => 'required|array|between:1,5',
                'files.*'       => 'required|exists:temporary_files,id,user_id,'.Auth::user()->id,
            ]);
            if ($validator->fails()){
                if ($request->get('files')) {
                    return redirect()->back()->withErrors($validator)->withInput()->with('files', TemporaryStore::whereIn('id', $request->input('files'))->get());
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $publication = new Publication();

            $publication->title         = $request->get('title');
            $publication->author_id     = Auth::user()->id;
            $publication->section_id    = $request->get('section');
            $publication->subject_id    = $request->get('subject');
            $publication->class         = $request->get('class');
            $publication->description   = $request->get('description');
            $publication->published     = 0;

            if ($publication->save()) {
                $files = TemporaryStore::whereIn('id', $request->input('files'))->get();
                foreach ($files as $file) {
                    $store  = new Store;

                    $store->name = $file->name;
                    $store->mime = $file->mime;
                    $store->path = $file->path;

                    $store->owner_id = $publication->id;
                    $store->owner_type = 'App\Models\Publication';

                    if($store->save()) {
                        $file->delete();
                    }
                }

                return redirect()->route('storage.index', $this->storage_sections->keyBy('id')[$request->get('section')]->code);
            }
        }

        return response()->view('pages.frontend.storage.upload', [
            'subjects' => $subjects,
        ]);
    }

    public function downloadArchive(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:publications,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $publication = Publication::where('id', $request->get('id'))->with('files')->first();

        if(extension_loaded('zip')) {
            $zip = new ZipArchive();

            $zip_name = str2url($publication->title).".zip"; // имя файла
            $path = 'storage/storage/fileы/temporary/';

            if($zip->open($path.$zip_name, ZIPARCHIVE::CREATE)!==true) {
                return redirect()->back()->withErrors(['message' => 'Не удалось создать архив, попробуйте позже']);
            }

            foreach ($publication->files as $file) {
                $zip->addFile(storage_path('app/public/' . $file->path), $file->name);
            }

            $zip->close();

            if(file_exists($path.$zip_name)) {

                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                readfile($path.$zip_name);

                unlink($path.$zip_name);
            }
        }
        return redirect()->back()->withErrors(['message' => 'Не удалось загрузить расширение ZIP, пожалуйста, обратитесь  к администратору']);
    }

}