<?php
Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'upload'], function($router) {
    Route::get('directory/{directory?}', 'Api\Upload\UploadController@getFilesFromDirectory');
    Route::get('{path}', 'Api\Upload\UploadController@show');
    Route::post('/client/{clientId}/setting/{settingId}/custom-name/{name}', 'Api\Upload\UploadController@uploadOriginal');
    Route::post('/client/{clientId}/setting/{settingId}', 'Api\Upload\UploadController@uploadOriginal');
    Route::post('delete', 'Api\Upload\UploadController@delete');

    Route::post('/createLocal', 'Api\Upload\UploadController@createLocal');
    Route::delete('/upload', 'Api\Upload\UploadController@delete')->name('filepond.delete');

});
