<?php

Route::group(['middleware' => 'api', 'prefix' => 'languages'], function ($router) {
    Route::get('/', 'Api\Language\LanguageController@index');
});
