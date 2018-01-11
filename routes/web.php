<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [
    'middleware' => 'guest',
    'uses' => 'Auth\LoginController@form',
    'as' => 'admin.login.form'
]);

Route::post('login/admin', [
    'uses' => 'Auth\LoginController@login',
    'as' => 'admin.login.process'
]);

Route::post('logout', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'logout'
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


