<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
    }


    /** Главная страница

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('home');
    }

    /** Главная страница
     * @return \Illuminate\Http\Response
     */
    public function indexWithLogin()
    {
        return response()->view('home', [
            'login' => 'login',
        ]);
    }

    /**
     * Ошибка заблокиованного аккаунта
     * @return \Illuminate\Http\Response
     */
    public function suspended()
    {
        return response()->view('errors.402');
    }

    /**
     * Главная авторизованого пользователя
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $user 		= Auth::user();
        return response()->view('home', [

        ]);
    }
}
