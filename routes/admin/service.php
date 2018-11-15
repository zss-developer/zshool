<?php

// Методы не требующие авторизации
//
Route::prefix('/admin')->group( function() {

    Route::prefix('/service')->group( function() {

        Route::name('admin.service.createLink')->get('/symlink', 'ServiceController@createSymlink');

        Route::name('admin.service.clearTemporary')->get('/temporary/clear', 'ServiceController@clearTemporaryFiles');


    });

});