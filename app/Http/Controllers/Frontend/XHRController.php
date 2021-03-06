<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Publication;
use App\Models\Store;
use App\Models\TemporaryStore;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;

class XHRController extends Controller
{
    /**
     * Получает список городов для страны
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function citiesGet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:locations,id',
            'term'		 => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) return response()->json(['status' => 'error', 'messages' => $validator->messages()], config('settings.xhr.code.error'));

        if ($request->get('country_id') == 0) {
            return response()->json(['status' => 'success', 'message' =>'Необходимо выбрать страну' ], config('settings.xhr.code.success'));
        }

        $country = Location::where('id',$request->get('country_id'))->first();

        if ($country->cities) {

            $cities = $country->cities;

            if ($request->get('term')) {
                $cities = $country->cities()->where('name','like', '%'.$request->get('term').'%')->get();
            }

            // Возвращаем список городов
            //
            return response()->json(['status' => 'success', 'cities' => $cities], config('settings.xhr.code.success'));
        }

        // Ошибка при обработке запроса
        //
        return response()->json(['status' => 'error', 'message' => 'cities not found'], config('settings.xhr.code.error'));
    }

    /**
     * Изменение изображения пользователя
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userPictureChange(Request $request)
    {
        $user   = Auth::user();

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:60000|dimensions:max_width=5120,max_height=3840',
        ]);

        if ($validator->fails()) return response()->json(['status' => 'error', 'messages' => $validator->messages()], config('settings.xhr.code.error'));

        // Получаем файл
        //
        $file  = $request->file('image');

        // Сохраняем файл в хранилище
        //
        $saved = store($file,'users/images/'. date("Y") . '/' . date("m"));

        // Если файл успешно сохранен
        //
        if($saved) {

            // Загружаем изображение в Intervention
            //
            $image  = Image::make(storage_path('app/public/' . $saved['path']));

            // Ресайзим изображение с сохранением пропорций
            //
            $image->resize(450, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Если изображение успешно обновлено
            //
            if($image->save()) {
                $store  = new Store;

                $store->name = $saved['name'];
                $store->mime = $saved['mime'];
                $store->path = $saved['path'];

                $store->owner_id = $user->id;
                $store->owner_type = 'App\Models\User';

                if($store->save()) {

                    $user->image_id = $store->id;
                    if($user->save()) {
                        return response()->json(['status' => 'success', 'message' => 'picture successfully changed'], config('settings.xhr.code.success'));
                    }
                }
            }
        }

        return response()->json(['status' => 'error', 'message' => 'error while saving picture'], config('settings.xhr.code.error'));
    }

    public function uploadFile(Request $request)
    {
        $user   = Auth::user();

        $validator = Validator::make($request->all(), [
            'files.*' => 'required|max:10000|mimes:txt,doc,docx,ppt,pptx,xls,xlsx,zip,rar,pdf'
        ]);

        if ($validator->fails()) return response()->json(['status' => 'error', 'messages' => $validator->messages()], config('settings.xhr.code.error'));

        // Получаем файл
        //
        $files  = $request->file('files');
        $result = [];

        foreach ($files as $file) {
            $saved = store($file,'storage/files/'. date("Y") . '/' . date("m"));

            $store  = new TemporaryStore();

            $store->user_id = $user->id;
            $store->name    = $saved['name'];
            $store->mime    = $saved['mime'];
            $store->path    = $saved['path'];
            if($store->save()) {
                Date::setLocale('ru');
                $result[] = [
                    'id'       => $store->id,
                    'name'     => $file->getClientOriginalName(),
                    'icon'     => mimeToIcon($store->mime),
                    'size'     => $file->getClientSize(),
                    'uploaded' => Date::parse($store->created_at)->format('j F Y').' в '.Date::parse($store->created_at)->format('H:i:s'),
                ];
            }
        }



            return response()->json(['status' => 'success', 'files' =>$result], config('settings.xhr.code.success'));

    }

    public function deleteFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:temporary_files,id',
        ]);

        if ($validator->fails()) return response()->json(['status' => 'error', 'messages' => $validator->messages()], config('settings.xhr.code.error'));

       $file = TemporaryStore::where('id',$request->get('id'))
           ->where('user_id', Auth::user()->id)
           ->first();

       if($file) {

           if (file_exists(storage_path('app/public/'.$file->path))) {
               unlink(storage_path('app/public/'.$file->path));
               $file->delete();
               return response()->json(['status' => 'success', 'message' =>'file successfully removed'], config('settings.xhr.code.success'));
           }
           return response()->json(['status' => 'success', 'message' =>'file already removed'], config('settings.xhr.code.success'));
       }

        return response()->json(['status' => 'error', 'message' => 'file not found'], config('settings.xhr.code.error'));
    }

}