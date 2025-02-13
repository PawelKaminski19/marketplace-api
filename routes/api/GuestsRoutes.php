<?php

Route::group(['middleware' => ['api'], 'prefix' => 'guest'], function ($router) {
    Route::post('uuid', 'Api\Signup\FindGuestController@findByUuid');
});
