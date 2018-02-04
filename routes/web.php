<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'bukanmhs'], function (){

    Route::get('hmj/{id}/{status}', [
        'uses' => 'PublicController@getDataPemilihHmj',
        'as' => 'hmj.data.hakpilih'
    ]);

    Route::get('dpm/{id}/{status}', [
        'uses' => 'PublicController@getDataPemilihDpm',
        'as' => 'dpm.data.hakpilih'
    ]);

    Route::get('bem/{status}', [
        'uses' => 'PublicController@getDataPemilihBem',
        'as' => 'bem.data.hakpilih'
    ]);

    Route::group(['prefix' => 'voting'], function (){

        Route::get('hmj/{jurusan}/{tipe}', [
            'uses' => 'PublicController@votingHmjDpm',
            'as' => 'admin.voting.hmj'
        ]);

        Route::get('dpm/{jurusan}/{tipe}', [
            'uses' => 'PublicController@votingHmjDpm',
            'as' => 'admin.voting.dpm'
        ]);

        Route::get('bem/{tipe}', [
            'uses' => 'PublicController@votingBem',
            'as' => 'admin.voting.bem'
        ]);

        Route::get('pengaturan', [
            'uses' => 'PublicController@pengaturanVoting',
            'as' => 'admin.voting.pengaturan'
        ]);

        Route::patch('pengaturan/update', [
            'uses' => 'PublicController@updatePengaturanVoting',
            'as' => 'admin.voting.pengaturan.update'
        ]);

    });
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


Route::group(['namespace' => 'Page'], function () {

    Route::get('pengaturan', function () {
        return view('admin.public.pengaturan');
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

Route::get('votingselesai', function () {
    return view('mahasiswa.votingselesai');
})->name('votingselesai');


Route::get('votingbelumselesai', function () {
    return view('mahasiswa.votingbelummulai');
})->name('votingbelummulai');
