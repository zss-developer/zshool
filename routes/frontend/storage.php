<?php


Route::prefix('/storage')->middleware('auth')->group(function () {

    Route::name('storage.upload')->match(['GET', 'POST'],'/upload', 'StorageController@storageUpload');

});

Route::prefix('/storage')->group(function () {

    Route::name('storage.download')->get('/download', 'StorageController@downloadArchive');

    Route::name('storage.index')->get('/{code}', 'StorageController@storageIndex');

    Route::name('storage.view')->get('/{code}/{id}', 'StorageController@storageView');



});
