<?php
Route::name('login')->get('login', 'Auth\LoginController@showLoginForm');
Route::name('login')->post('login', 'Auth\LoginController@login');
Route::name('logout')->post('logout', 'Auth\LoginController@logout');

// Registration routes...
Route::name('register')->get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset routes...
Route::name('password.request')->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::name('auth.password.email')->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::name('password.reset')->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');