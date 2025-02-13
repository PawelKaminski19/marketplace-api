<?php
Route::group(['middleware' => 'api'], function ($router) {

   Route::group(['middleware' => ['api'], 'prefix' => 'domain'], function ($router) {
       Route::get('/', 'Api\Domain\DomainController@index');
       Route::post('url', 'Api\Domain\DomainController@searchByUrl');
   });
});
