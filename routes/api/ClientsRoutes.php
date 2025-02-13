<?php

Route::group(['middleware' => ['api'], 'prefix' => 'client'], function ($router) {
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'client'], function ($router) {
    Route::get('/my', 'Api\Client\ClientController@findMyClients');
    Route::get('/{clientId}', 'Api\Client\ClientController@find');
    Route::get('/', 'Api\Client\ClientController@index');
    
});
