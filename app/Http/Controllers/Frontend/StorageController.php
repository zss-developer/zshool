<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Publication;
use App\Models\StorageSection;
use App\Models\Subject;
use App\Models\TemporaryStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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


        return response()->view('pages.frontend.storage.index', [
            'section' => $section,
            'subjects' => $subjects,
        ]);

    }

    public function storageUpload(Request $request)
    {
        $this->middleware('auth');
        $subjects = Subject::all();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'header'        => 'required|string|max:191',
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

            $publication->title = $request->get('title');
            $publication->author_id = Auth::user()->id;
            $publication->section_id = $request->get('section');
            $publication->subject_id = $request->get('subject');
            $publication->class = $request->get('c');
            $publication->title = $request->get('title');

        }

        return response()->view('pages.frontend.storage.upload', [
            'subjects' => $subjects,
        ]);
    }
}