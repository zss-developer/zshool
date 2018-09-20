<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * CabinetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
	 * Главная текущего пользователя
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return response()->view('pages.frontend.user.index', [
            'view'      => 'pages.frontend.user.settings.general',
            'user'      => $user,
        ]);
    }

    /**
	 * Настройки безопасности
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function settingsSecurity(Request $request)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'password'     => 'required|hash:' . $user->password,
                'new_password' => 'required|alphaNum|between:6,16|confirmed'
            ]);

            if ($validator->fails()) return redirect()->back()->withErrors($validator);

            $user->password = Hash::make($request->get('new_password'));
            $user->save();

            return redirect()->back()->with('message', 'Настройки безопасности обновлены');
        }

        return response()->view('pages.frontend.user.index', [
            'view' => 'pages.frontend.user.settings.security',
            'user' => $user,
        ]);
    }

	/**
	 * Настройки контактов
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */
	public function settingsContacts(Request $request)
    {
        $user = Auth::user();

        // Все страны
        $countries  = Location::where('parent_id',0)->get();

        if ($request->isMethod('post')) {

            // Убираем маску с телефона
            // Для обработки и сохранения
            $request->merge(['phone' => str_replace('-', '', filter_var($request->get('phone'), FILTER_SANITIZE_NUMBER_INT))]);

            $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name'  => 'required|max:35',
                'city'   => 'required|numeric|exists:locations,id',
                'phone'      => 'nullable|max:19|unique:users,phone,'.$user->id,
                'email'      => 'required|max:35|email|unique:users,email,'.$user->id,
                'about'      => 'nullable|max:500',
            ]);

            $user->first_name  = $request->get('first_name');
            $user->last_name   = $request->get('last_name');
            $user->location_id = $request->get('city');
            $user->phone       = $request->get('phone');
            $user->email       = $request->get('email');
            $user->about       = $request->get('about');

            $user->save();

            return redirect()->back()->with('message', 'Отлично! Информация успешно обновлена.');
        }

        return response()->view('pages.frontend.user.index', [
            'view'      => 'pages.frontend.user.settings.contacts',
            'user'      => $user,
            'countries'     => $countries,
        ]);
    }

	/**
	 * Настройки уведомлений
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function settingsNotifications(Request $request)
	{

		$user = Auth::user();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'notifications'     => 'nullable|array',
                'notifications.*'   => 'nullable|in:subscription,reply,message',
            ]);

            if ($validator->fails()) return redirect()->back()->withErrors($validator);

            $user->notifications = $request->get('notifications', []);
            $user->save();
        }

		return response()->view('pages.frontend.user.index', [
			'view' => 'pages.frontend.user.settings.notify',
			'user' => $user
		]);
	}
}
