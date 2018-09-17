<?php

namespace App\Http\Controllers\Frontend;

use App\Models\StorageSection;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;use Illuminate\View\View;

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
}