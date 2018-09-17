<?php

// Пользователь
//
Route::prefix('/user')->middleware('auth')->group( function() {

	// Главная пользователя
    Route::name('user.index')->get('/', 'UserController@index');

	// Настройки
	//
    Route::prefix('/settings')->group( function() {
		// Безопасность
        Route::name('user.settings.security')->match(['GET', 'POST'], '/security', 'UserController@settingsSecurity');

		// Контакты
        Route::name('user.settings.contacts')->match(['GET', 'POST'], '/contacts', 'UserController@settingsContacts');

		// Уведомления
        Route::name('user.settings.notifications')->match(['GET', 'POST'], '/notifications', 'UserController@settingsNotifications');
	});
});