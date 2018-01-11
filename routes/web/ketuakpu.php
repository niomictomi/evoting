<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

Route::group(['prefix' => 'kakpu'], function() {

    Route::get('dashboard', 'KakpuController@index')->name('kakpu.dashboard');

});