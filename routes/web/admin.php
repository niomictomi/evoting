<?php

Route::group(['namespace' => 'Page', 'prefix' => 'admin'], function (){
    Route::get('dashboard', [
        'uses' => 'AdminController@dashboard',
        'as' => 'admin.dashboard'
    ]);

    Route::get('voting/{waktu}/{tipe}', [
        'uses' => 'AdminController@voting',
        'as' => 'admin.voting'
    ]);
});