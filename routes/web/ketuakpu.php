<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

Route::group(['namespace' => 'Page\Panitia', 'prefix' => 'kakpu'], function() {

    Route::get('dashboard', 'KakpuController@index')->name('kakpu.dashboard');

    Route::get('openbox', 'KakpuController@openbox')->name('kakpu.openbox');

});