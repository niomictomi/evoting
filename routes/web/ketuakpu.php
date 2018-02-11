<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

Route::group(['prefix' => 'kakpu'], function() {

    Route::get('dashboard', 'KakpuController@index')->name('kakpu.dashboard');

    Route::get('buka', 'KakpuController@buka')->name('kakpu.buka');

    Route::post('voting/buka', [
        'uses' => 'KakpuController@save',
        'as' => 'kakpu.simpan'
    ]);

    Route::get('print', 'KakpuController@printhasil')->name('kakpu.print');

});