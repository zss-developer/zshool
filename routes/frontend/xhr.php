<?php

// Методы не требующие авторизации
//
Route::prefix('/xhr')->group( function() {

    // Список городов
    //
    Route::name('xhr.cities')->get('/cities', 'XHRController@citiesGet');

});

// Методы требующие аторизации
//
Route::prefix('/xhr')->middleware('auth')->group( function() {

    // Пользователь
    //
    Route::prefix('/user')->group( function() {

        // Аватар
        //
        Route::prefix('/picture')->group( function() {

            // Смена аватара пользователя
            Route::name('xhr.user.picture.change')->match(['GET', 'POST'], '/change', 'XHRController@userPictureChange');
        });

    });

});
