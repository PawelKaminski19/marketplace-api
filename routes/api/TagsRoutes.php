<?php

Route::group(['middleware' => ['api'], 'as' => 'tags.', 'prefix' => 'tags'], function () {
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('website/{websiteId}', ['as' => 'find', 'uses' => 'Api\Tags\TagsController@index']);
        Route::post('/', ['as' => 'tags', 'uses' => 'Api\Tags\TagsController@save']);
    });
});
