<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------DOSEN--------------------------------//

Route::group(['namespace' => 'Page', 'prefix' => 'dosen'], function() {

    //Route::get('dashboard', 'Page\Dosenwd1Controller@index')->name('dosen.dashboard');

    Route::get('dashboard', [
        'uses' => 'Dosenwd1Controller@index',
        'as' => 'dosen.dashboard'
    ]);

    Route::get('openbox', 'Dosenwd1Controller@openbox')->name('dosen.openbox');


});


