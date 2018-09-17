<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Auth routes
 * Namespaces indicate folder structure
 */

Route::prefix('/')->middleware(['web'])->domain(env('APP_URL'))->group( function () {
    require (__DIR__ . '/common/auth.php');
});

/**
 * Public routes
 * Namespaces indicate folder structure
 */
Route::prefix('/')->namespace('Frontend')->middleware(['web'])->domain(env('APP_URL'))->group( function () {
    require (__DIR__ . '/frontend/base.php');
    require (__DIR__ . '/frontend/storage.php');
    require (__DIR__ . '/frontend/user.php');
    require (__DIR__ . '/frontend/xhr.php');
});