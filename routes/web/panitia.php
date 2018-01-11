<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------Panitia--------------------------------//

Route::group(['namespace' => 'Page\Panitia', 'prefix' => 'panitia'], function() {

    Route::get('dashboard', 'HmjController@index')->name('panitia.dashboard');

    Route::get('paslon', 'HmjController@paslon')->name('panitia.paslon');

    Route::get('form', 'HmjController@form')->name('panitia.form');

    Route::post('form/add', 'HmjController@formsave')->name('panitia.form.save');

    Route::get('resepsionis', 'HmjController@resepsionis')->name('panitia.resepsionis');

    Route::get('resepsionis/search', 'HmjController@carimhs');

    Route::post('resepsionis/{id}/update', 'HmjController@updatestatus');

});


