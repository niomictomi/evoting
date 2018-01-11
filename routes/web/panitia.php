<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------Panitia--------------------------------//

Route::group(['prefix' => 'panitia'], function() {

    Route::get('dashboard', 'PanitiaController@index')->name('panitia.dashboard');

});


