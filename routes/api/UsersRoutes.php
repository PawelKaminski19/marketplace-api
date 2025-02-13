<?php

Route::group(['middleware' => ['api','jwt.verify'],'prefix' => 'users' ], function ($router) {
        //assign role to user
        Route::put('{userId}/roles/{roleId}', 'Api\Admin\RolesAndPermissions\RoleController@assignRolesAndPermissions');
        Route::delete('{userId}/roles/{roleId}', 'Api\Admin\RolesAndPermissions\RoleController@revokeRolesAndPermissions');
        //all users
        Route::get('/', 'Api\Admin\Users\UserController@index');
        //users by clients
        Route::get('clients/{clientId}', 'Api\Admin\Users\UserController@getByClient');
});

Route::get('customers/login-link/{email}/{websiteId?}', 'Api\Login\LoginByLink\Customer\SendLinkController@send');
Route::get('customers/login-by-link/{hash}', 'Api\Login\LoginByLink\Customer\SendVerificationCodeController@send'); 
Route::post('customers/login-by-link/{hash}', 'Api\Login\LoginByLink\Customer\LoginByLinkController@login');

