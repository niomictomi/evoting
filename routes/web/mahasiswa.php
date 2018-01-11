<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

Route::prefix('mahasiswa')->group(function() {

    Route::namespace('Page')->group(function() {

        Route::get('vote', [
            'uses' => 'MahasiswaController@vote',
            'as' => 'mahasiswa.halaman.voting'
        ]);

    });

});

Route::prefix('vote')->group(function() {

    Route::post('hmj', [
        'uses' => 'VoteController@voteHMJ',
        'as' => 'mahasiswa.vote.hmj'
    ]);

    Route::post('bem', [
        'uses' => 'VoteController@voteBEM',
        'as' => 'mahasiswa.vote.bem'
    ]);

    Route::post('dpm', [
        'uses' => 'VoteController@voteDPM',
        'as' => 'mahasiswa.vote.dpm'
    ]);

});