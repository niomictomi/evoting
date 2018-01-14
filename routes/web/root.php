<?php

Route::prefix('root')->group(function () {

    Route::group(['namespace' => 'Page'], function () {

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

    Route::put('tambah/mahasiswa', [
        'uses' => 'MahasiswaController@tambahDariFile',
        'as' => 'root.tambah.mahasiswa'
    ]);

});