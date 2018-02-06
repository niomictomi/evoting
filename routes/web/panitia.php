<?php

// Jangan lupa untuk menggunakan middleware pada
// controller

// Jangan lupa untuk menggunakan middleware pada
// controller

//------------------------------Panitia--------------------------------//

Route::group(['prefix' => 'panitia'], function() {

    Route::get('dashboard', 'PanitiaController@index')->name('panitia.dashboard');

    Route::get('paslon', 'PanitiaController@paslon')->name('panitia.paslon');

    Route::post('paslon/delete', 'PanitiaController@hmjdelete')->name('paslon.delete');

    Route::get('paslon/dpm', 'PanitiaController@paslondpm')->name('panitia.paslon.dpm');

    Route::post('paslon/dpm/delete', 'PanitiaController@dpmdelete')->name('paslon.delete.dpm');

    Route::get('paslon/bem', 'PanitiaController@paslonbemf')->name('panitia.paslon.bem');

    Route::post('paslon/bem/delete', 'PanitiaController@bemdelete')->name('paslon.delete.bem');

    Route::get('paslon/form/hmj', 'PanitiaController@formhmj')->name('form.hmj');

    Route::post('paslon/form/hmj/save', 'PanitiaController@hmjsave')->name('hmj.save');

    Route::get('paslon/form/dpm', 'PanitiaController@formdpm')->name('form.dpm');

    Route::post('paslon/form/dpm/save', 'PanitiaController@dpmsave')->name('dpm.save');

    Route::get('paslon/form/bem', 'PanitiaController@formbem')->name('form.bem');

    Route::post('paslon/form/bem/save', 'PanitiaController@bemsave')->name('bem.save');

    Route::post('paslon/add', 'PanitiaController@paslonform');

    Route::get('paslon/{id}/update', 'PanitiaController@paslonedit');

    Route::post('paslon/update/save', 'PanitiaController@pasloneditsave')->name('update.hmj');

    Route::get('paslon/{id}/dpm/update', 'PanitiaController@paslondpmedit');

    Route::get('paslon/{id}/bem/update', 'PanitiaController@paslonbemedit');

    Route::get('print/{id}', 'PanitiaController@printnim')->name('print.nim');

    //Route::resource('resepsionis', 'PanitiaController');

    //Route::get('api', 'PanitiaController@api')->name('api.resepsionis');

    Route::get('resepsionis', 'PanitiaController@resepsionis')->name('panitia.resepsionis');

    Route::get('resepsionis/search', 'PanitiaController@carimhs')->name('cari');

    Route::post('resepsionis/{id}/update', 'PanitiaController@updatestatus')->name('resepsionis.update');

});


