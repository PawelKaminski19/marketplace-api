<?php

Route::group(['middleware' => ['api'], 'prefix' => 'brand'], function ($router) {
    Route::get('{id}', 'Api\Brand\BrandsController@show');
    Route::get('slug/{slug}', 'Api\Brand\BrandsController@getBySlug');
});
