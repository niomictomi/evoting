<?php

Route::group(['namespace' => 'Page', 'prefix' => 'root'], function (){
    Route::get('dashboard', [
        'uses' => 'RootController@dashboard',
        'as' => 'root.dashboard'
    ]);
});