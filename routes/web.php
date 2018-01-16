<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('hmj/{id}/{status}', [
    'uses' => 'PublicController@getDataPemilihHmj',
    'as' => 'hmj.data.pemilih'
]);

Route::group(['namespace' => 'Auth'], function () {

    Route::get('login', [
        'uses' => 'LoginController@form',
        'as' => 'admin.login.form'
    ]);
    
    Route::post('login/admin', [
        'uses' => 'LoginController@login',
        'as' => 'admin.login.process'
    ]);
    
    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout'
    ]);

});


Route::group(['namespace' => 'Page'], function () {

    Route::get('pengaturan', function () {
        return view('admin.pengaturan');
    })->name('admin.pengaturan')->middleware('bukanmhs');

});

Route::post('pengaturan', [
    'uses' => 'UserController@pengaturan',
    'as' => 'admin.pengaturan'
]);

Route::post('ubah/password', [
    'uses' => 'UserController@ubahPassword',
    'as' => 'admin.ubah.password'
]);

Route::post('daftar/mahasiswa', [
    'uses' => 'MahasiswaController@daftar',
    'as' => 'daftar.mahasiswa'
]);

// Route public untuk login mahasiswa

Route::group(['namespace' => 'Page', 'prefix' => 'mahasiswa'], function() {

    Route::get('login', [
        'uses' => 'MahasiswaController@login',
        'as' => 'mahasiswa.login'
    ]);

});

Route::prefix('mahasiswa')->group(function() {

    Route::namespace('Auth')->group(function() {

        Route::post('login', [
            'uses' => 'LoginController@loginMahasiswa',
            'as' => 'mahasiswa.login'
        ]);

    });

});
