<?php

Route::group(['namespace' => 'Page', 'prefix' => 'root'], function () {

    Route::get('dashboard', [
        'uses' => 'RootController@dashboard',
        'as' => 'root.dashboard'
    ]);

    Route::get('mahasiswa', [
        'uses' => 'RootController@mahasiswa',
        'as' => 'root.mahasiswa'
    ]);

    Route::get('reset', [
        'uses' => 'RootController@reset',
        'as' => 'root.reset'
    ]);

});