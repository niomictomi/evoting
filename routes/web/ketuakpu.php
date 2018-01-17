<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

Route::group(['prefix' => 'kakpu'], function() {

    Route::get('dashboard', 'KakpuController@index')->name('kakpu.dashboard');

    Route::get('buka', 'KakpuController@buka')->name('kakpu.buka');

    Route::post('buka/save', 'KakpuController@save')->name('kakpu.buka.save');

});