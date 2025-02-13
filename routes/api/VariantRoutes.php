<?php

Route::group(['middleware' => ['api', 'jwt.verify'], 'as' => 'variant.', 'prefix' => 'variant'], function () {
    Route::get('', ['as' => 'list', 'uses' => 'Api\Variant\VariantsController@index']);
    Route::post('', ['as' => 'create', 'uses' => 'Api\Variant\VariantsController@store']);
    Route::get('/{variant}', ['as' => 'show', 'uses' => 'Api\Variant\VariantsController@show']);
    Route::patch('/{variant}', ['as' => 'update', 'uses' => 'Api\Variant\VariantsController@update']);
    Route::delete('/{variant}', ['as' => 'show', 'uses' => 'Api\Variant\VariantsController@delete']);
});
