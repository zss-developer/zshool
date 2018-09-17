<?php

Route::prefix('/storage')->group(function () {

    Route::name('storage.index')->get('/{code}', 'StorageController@storageIndex');
});