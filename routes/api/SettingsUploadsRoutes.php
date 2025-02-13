<?php

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'settings-uploads'], function($router) {
    Route::get('', 'Api\SettingsUploads\SettingsUploadsController@index');
    Route::get('client/{clientId}', 'Api\SettingsUploads\SettingsUploadsController@byClientWebsiteModelType');
    Route::get('client/{clientId}/website/{websiteId}', 'Api\SettingsUploads\SettingsUploadsController@byClientWebsiteModelType');
    Route::get('client/{clientId}/website/{websiteId}/model/{model}', 'Api\SettingsUploads\SettingsUploadsController@byClientWebsiteModelType');
    Route::get('client/{clientId}/website/{websiteId}/model/{model}/type/{type}', 'Api\SettingsUploads\SettingsUploadsController@byClientWebsiteModelType');

    Route::put('{id}/client/{clientId}', 'Api\SettingsUploads\SettingsUploadsController@updateByClient');

    Route::get('{id}', 'Api\SettingsUploads\SettingsUploadsController@show');
    //adding settings uploads
    Route::post('core', 'Api\SettingsUploads\SettingsUploadsController@storeCore');
    Route::post('client/{clientId}', 'Api\SettingsUploads\SettingsUploadsController@storeByClient');

    Route::put('{id}', 'Api\SettingsUploads\SettingsUploadsController@update');
    Route::delete('{id}/client/{clientId}', 'Api\SettingsUploads\SettingsUploadsController@deleteByClient');
    Route::delete('{id}/core', 'Api\SettingsUploads\SettingsUploadsController@deleteCore');
});
