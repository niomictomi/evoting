<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------Panitia--------------------------------//

Route::group(['prefix' => 'panitia'], function() {

    Route::get('dashboard', 'PanitiaController@index')->name('panitia.dashboard');

    Route::get('paslon', 'PanitiaController@paslon')->name('panitia.paslon');

    Route::get('paslon/form', 'PanitiaController@paslonform')->name('panitia.paslon.form');

    Route::get('resepsionis', 'PanitiaController@resepsionis')->name('panitia.resepsionis');

    Route::get('resepsionis/search', 'PanitiaController@carimhs');

    Route::post('resepsionis/{id}/update', 'PanitiaController@updatestatus');

});


