<?php

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', 'Api\Login\AuthController@login');
    Route::post('affiliate/login', 'Api\Login\UsersLogin\AffiliateLoginController@login');
    Route::post('brand/login', 'Api\Login\UsersLogin\BrandLoginController@login');
    Route::post('clients/{slug}/login', 'Api\Login\UsersLogin\ClientsEmployeeLoginController@loginByUrl');
    Route::post('clients/login', 'Api\Login\UsersLogin\ClientsEmployeeLoginController@login');
    Route::post('customers/login', 'Api\Login\UsersLogin\CustomerLoginController@login');
    Route::post('system/{slug}/login', 'Api\Login\UsersLogin\SoftwareOwnerLoginController@login');
    Route::post('clients/onbehalf/logout', 'Api\Login\OnBehalfController@onBehalfLogout');

    Route::group(['middleware' => 'jwt.verify'], function ($router) {
        Route::post('logout', 'Api\Login\AuthController@logout');
        Route::post('refresh', 'Api\Login\AuthController@refresh');
        Route::get('me', 'Api\Login\AuthController@me');

        Route::post('choose-account', 'Api\Login\ChooseAccountController@chooseAccount');
        Route::post('affiliate/choose-account', 'Api\Login\ChooseAccount\AffiliateChooseAccountController@chooseAccount');
        Route::post('clients/choose-account', 'Api\Login\ChooseAccount\ClientsEmployeeChooseAccountController@chooseAccount');
        Route::post('customers/choose-account', 'Api\Login\ChooseAccount\CustomerChooseAccountController@chooseAccount');
        Route::post('brand/choose-account', 'Api\Login\ChooseAccount\BrandChooseAccountController@chooseAccount');

        Route::post('clients/onbehalf', 'Api\Login\OnBehalfController@onBehalfLogin');
        Route::post('customers/onbehalf', 'Api\Login\OnBehalfController@onBehalfCustomerLogin');
    });

});
