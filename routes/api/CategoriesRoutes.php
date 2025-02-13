<?php

Route::group(['middleware' => ['api'], 'prefix' => 'category'], function ($router) {
    Route::get('tree/{websiteId?}', 'Api\Category\CategoryController@tree');
    Route::post('path/website', 'Api\Category\CategorySearchController@getByPathAndWebsite');
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'category'], function ($router) {
    Route::post('store', 'Api\Category\CategoryController@storeCategory');
    Route::put('{id}/update', 'Api\Category\CategoryController@updateCategory');
    Route::get('{id}', 'Api\Category\CategoryController@showCategory');
    Route::post('{id}/delete', 'Api\Category\CategoryController@deleteCategory');

    Route::get('get-root/{id}', 'Api\Category\CategoryController@getRootCategory');
    Route::get('get-children/{id}', 'Api\Category\CategoryController@getChildrenCategories');
    Route::get('change-position/{categoryId}/{position}/{parent?}', 'Api\Category\CategoryController@changePosition');
});
