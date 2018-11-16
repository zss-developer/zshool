<?php

namespace App\Http\Controllers\Admin;

use App\Models\TemporaryStore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function clearTemporaryFiles(Request $request)
    {
        $files = TemporaryStore::where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1 days")))->get();

        if ($files) {
            foreach ($files as $file) {
                if (file_exists(storage_path('app/public/'.$file->path))) {
                    unlink(storage_path('app/public/'.$file->path));
                }
                $file->delete();
            }
            return response()->json(['status' => 'success', 'message' =>'Temporary files successfully removed'], config('settings.xhr.code.success'));
        }

    }

    public function createSymlink(Request $request)
    {

    }

}