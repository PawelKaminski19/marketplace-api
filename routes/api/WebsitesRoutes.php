<?php

Route::group(['middleware' => ['api'], 'as' => 'website.', 'prefix' => 'websites'], function () {
    Route::get('url', 'Api\Website\WebsiteController@findByURL');
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('{id}', ['as' => 'find', 'uses' => 'Api\Website\WebsiteController@find']);
        Route::get('{id}/client/{clientId}', ['as' => 'find', 'uses' => 'Api\Website\WebsiteController@findByClient']);
    });
});
