<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------Panitia--------------------------------//

Route::group(['prefix' => 'panitia'], function() {

    Route::get('dashboard', 'PanitiaController@index')->name('panitia.dashboard');

    Route::get('paslon', 'PanitiaController@paslon')->name('panitia.paslon');

    Route::get('paslon/form/hmj', 'PanitiaController@formhmj')->name('form.hmj');

    Route::post('paslon/form/hmj/save', 'PanitiaController@hmjsave')->name('hmj.save');

    Route::get('paslon/form/dpm', 'PanitiaController@formdpm')->name('form.dpm');

    Route::post('paslon/form/dpm/save', 'PanitiaController@dpmsave')->name('dpm.save');

    Route::get('paslon/form/bem', 'PanitiaController@formbem')->name('form.bem');

    Route::post('paslon/form/bem/save', 'PanitiaController@bemsave')->name('bem.save');

    Route::post('paslon/add', 'PanitiaController@paslonform');

    //Route::resource('resepsionis', 'PanitiaController');

    //Route::get('api', 'PanitiaController@api')->name('api.resepsionis');

    Route::get('resepsionis', 'PanitiaController@resepsionis')->name('panitia.resepsionis');

    Route::get('resepsionis/search', 'PanitiaController@carimhs')->name('cari');

    Route::post('resepsionis/{id}/update', 'PanitiaController@updatestatus')->name('resepsionis.update');

});


