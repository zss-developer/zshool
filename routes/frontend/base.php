<?php

// Some specific error routes
Route::name('suspended')->get('home', 'IndexController@suspended');

// Welcome Route
Route::name('index.login')->middleware('guest')->get('/login', 'IndexController@indexWithLogin');

Route::name('index')->middleware('guest')->get('/', 'IndexController@index');

// Home Route
Route::name('home')->get('home', 'IndexController@home');