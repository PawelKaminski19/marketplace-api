<?php

Route::group(['middleware' => ['api', 'jwt.verify'], 'as' => 'variant-group.', 'prefix' => 'variant-group'], function () {
    Route::get('', ['as' => 'list', 'uses' => 'Api\VariantGroup\VariantGroupsController@index']);
    Route::post('', ['as' => 'create', 'uses' => 'Api\VariantGroup\VariantGroupsController@store']);
    Route::get('/{variantGroup}', ['as' => 'show', 'uses' => 'Api\VariantGroup\VariantGroupsController@show']);
    Route::patch('/{variantGroup}', ['as' => 'update', 'uses' => 'Api\VariantGroup\VariantGroupsController@update']);
    Route::delete('/{variantGroup}', ['as' => 'show', 'uses' => 'Api\VariantGroup\VariantGroupsController@delete']);
});
