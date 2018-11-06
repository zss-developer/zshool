<?php

namespace App\Http\Controllers\Frontend;

use App\Models\StorageSection;
use App\Models\Subject;
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
        $subjects = Subject::all();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'header'        => 'required|string|max:191',
                'section'       => 'required|exists:storage_sections,id',
                'subject'       => 'required|exists:subjects,id',
                'description'   => 'nullable',
                'files'         => 'required',
            ]);
            dd($request->get('files'));
            if ($validator->fails()){
                if ($request->get)
                return redirect()->back()->withErrors($validator)->withInput();

            }

        }

        return response()->view('pages.frontend.storage.upload', [
            'subjects' => $subjects,
        ]);
    }
}