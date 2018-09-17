<?php

if(!function_exists('store')) {

    /**
     * @param $file
     * @param $directory
     * @return array|bool
     */
    function store($file, $directory = false)
    {
        $path	  = ($directory) ? $directory : date("Y") . '/' . date("m");

        $original = $file->getClientOriginalName();
        $mime     = $file->getClientMimeType();
        $name  	  = pathinfo($original, PATHINFO_FILENAME);

        $store    = $file->store($path, 'public');

        if($store) {
            return [ 'name' => $name, 'mime' => $mime, 'path' => $store ];
        }

        return false;
    }
}