<?php

Route::get('/', function () {
    return view('welcome');
});

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
