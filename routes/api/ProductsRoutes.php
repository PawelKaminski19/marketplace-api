<?php

Route::group(['middleware' => ['api'], 'prefix' => 'product'], function ($router) {
    Route::get('website/{websiteId}/{active?}', 'Api\Product\ProductSearchController@getByWebsite');
    Route::post('url/website', 'Api\Product\ProductSearchController@getByUrlAndWebsite');
    Route::post('url', 'Api\Product\ProductSearchController@getByUrl');
    Route::get('by-client/{clientId}/{websiteId?}/{active?}', 'Api\Product\ProductSearchController@getByClient');
    Route::get('by-brand/{brandId}/{websiteId?}/{active?}', 'Api\Product\ProductSearchController@getByBrand');
    Route::get('by-category/{categoryId}/{websiteId?}/{active?}', 'Api\Product\ProductSearchController@getByCategory');
    Route::get('by-name/{name}/{websiteId?}/{active?}', 'Api\Product\ProductSearchController@getByName');
    Route::get('by-price/{price}/{websiteId?}/{showPrice?}/{active?}', 'Api\Product\ProductSearchController@getByPrice');
    Route::get('by-price-range/{minPrice?}/{maxPrice?}/{showPrice?}/{active?}', 'Api\Product\ProductSearchController@getByPriceRange');
    Route::get('by-ean/{ean}/{websiteId?}/{active?}', 'Api\Product\ProductSearchController@getByEan');

    Route::group(['middleware' => ['jwt.verify']], function ($router) {
        Route::get('/', 'Api\Product\ProductSearchController@getAll');
        Route::get('/{product}', ['as' => 'show', 'uses' => 'Api\Product\ProductController@showProduct']);
        Route::post('/', ['as' => 'create', 'uses' => 'Api\Product\ProductController@storeProduct']);
        Route::put('/{product}', ['as' => 'update', 'uses' => 'Api\Product\ProductController@updateProduct']);
        Route::delete('/{product}', ['as' => 'delete', 'uses' => 'Api\Product\ProductController@deleteProduct']);
    });
});

Route::group(['middleware' => ['api'], 'prefix' => 'product-website'], function ($router) {
    Route::post('by-category', 'Api\Product\ProductSearchController@getByWebsiteAndCategory');
});

