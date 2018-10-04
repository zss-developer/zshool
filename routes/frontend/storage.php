<?php

Route::prefix('/storage')->group(function () {

    Route::name('storage.upload')->match(['GET', 'POST'],'/upload', 'StorageController@storageUpload');

    Route::name('storage.index')->get('/{code}', 'StorageController@storageIndex');
});