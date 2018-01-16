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

    Route::delete('reset', [
        'uses' => 'RootController@reset',
        'as' => 'root.reset'
    ]);

    Route::post('passwordcheck', [
        'uses' => 'RootController@passwordCheck',
        'as' => 'root.password.check'
    ]);

    Route::put('tambah/mahasiswa/file', [
        'uses' => 'MahasiswaController@tambahDariFile',
        'as' => 'root.tambah.mahasiswa.file'
    ]);

    Route::put('tambah/mahasiswa/individu', [
        'uses' => 'MahasiswaController@tambah',
        'as' => 'root.tambah.mahasiswa.individu'
    ]);

});