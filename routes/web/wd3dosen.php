<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------DOSEN--------------------------------//

Route::group(['prefix' => 'dosen'], function() {

    Route::get('dashboard', 'Wd3dosenController@index')->name('dosen.dashboard');

    Route::get('buka', 'Wd3dosenController@buka')->name('dosen.buka');

    Route::post('buka/{id}/save', 'Wd3dosenController@save')->name('dosen.buka.save');
});


