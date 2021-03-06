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
        $name  	  = $original;

        $store    = $file->store($path, 'public');

        if($store) {
            return [ 'name' => $name, 'mime' => $mime, 'path' => $store ];
        }

        return false;
    }

    if(!function_exists('rus2translit')) {
        function rus2translit($string)
        {
            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v',
                'г' => 'g', 'д' => 'd', 'е' => 'e',
                'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
                'и' => 'i', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

                'А' => 'A', 'Б' => 'B', 'В' => 'V',
                'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'I', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N',
                'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
                'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            );
            return strtr($string, $converter);
        }
    }

    if(!function_exists('str2url')) {
        function str2url($str)
        {
            // переводим в транслит
            $str = rus2translit($str);
            // в нижний регистр
            $str = strtolower($str);
            // заменям все ненужное нам на "-"
            $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
            // удаляем начальные и конечные '-'
            $str = trim($str, "-");
            return $str;
        }
    }

    if(!function_exists('mimeToIcon')) {
        function mimeToIcon($mime) {
            $mimes = [
                'text/plain'  => 'la-file-text-o text-info',
                'application/msword'  => 'la-file-word-o text-primary',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'  => 'la-file-word-o text-primary',
                'application/vnd.ms-powerpoint'  => 'la-file-powerpoint-o text-warning',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'  => 'la-file-powerpoint-o text-warning',
                'application/vnd.ms-excel'  => 'la-file-excel-o text-success',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'  => 'la-file-excel-o text-success',
                'application/octet-stream'  => 'la-file-archive-o ks-color-brown',
                'application/x-zip-compressed'  => 'la-file-archive-o ks-color-brown',
                'application/pdf'  => 'la-file-pdf-o text-danger',
            ];

            return (array_key_exists($mime, $mimes) !== false ? $mimes[$mime] : 'la-file-o ks-color-info');
        }
    }

}