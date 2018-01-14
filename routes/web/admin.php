<?php

Route::group(['prefix' => 'admin'], function (){
    Route::get('dashboard', [
        'uses' => 'AdminController@dashboard',
        'as' => 'admin.dashboard'
    ]);

    Route::get('user', [
        'uses' => 'AdminController@panitia',
        'as' => 'admin.panitia'
    ]);

    Route::group(['prefix' => 'tambah'], function (){
        Route::put('panitia', [
            'uses' => 'AdminController@tambahPanitia',
            'as' => 'admin.tambah.panitia'
        ]);
    });
});