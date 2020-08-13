<?php

Route::group(['as' => 'laravelmultipwa.'], function() {
    Route::get('/manifest-{name?}.json', 'LaravelMPWAController@manifestJson')->name('manifest');

    Route::get('/offline/', 'LaravelMPWAController@offline');
});
