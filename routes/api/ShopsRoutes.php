<?php

Route::group(['middleware' => ['api'], 'prefix' => 'shops'], function ($router) {
    Route::get('/{websiteId?}/brands', 'Api\Shop\ShopController@getBrands');
    Route::get('/brands', 'Api\Shop\ShopController@getBrands');
    Route::get('/', 'Api\Shop\ShopController@getWebsites');
    Route::get('{slug}', 'Api\Shop\ShopController@getBySlug');
});
