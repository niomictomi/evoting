<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------DOSEN--------------------------------//

Route::group(['prefix' => 'dosen'], function() {

    Route::get('dashboard', 'Wd3dosenController@index')->name('dosen.dashboard');


});


