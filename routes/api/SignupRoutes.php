<?php

Route::group(['middleware' => 'api'], function ($router) {

    Route::post('initial', 'Api\Signup\GuestApiController@initialVisit');
    
    Route::group(['prefix' => 'signup'], function ($router) {
        //initial visit
        Route::post('', 'Api\Signup\GuestApiController@signup');
        //step 1 - create account
        Route::post('create-shop', 'Api\Signup\CreateShopController@create');
        //step 2 - send-sms
        Route::post('send-sms', 'Api\Signup\VerifyPhoneController@sendSMS');
        //step 2 - verify phone
        Route::post('verify-phone', 'Api\Signup\VerifyPhoneController@verify');
        //step 2 - verify email
        Route::post('verify-email', 'Api\Signup\VerifyEmailController@verify');
        //step 2 - resend email if lost
        Route::post('resend-email', 'Api\Signup\GuestApiController@resendEmail');
        //step 3 - create shop
        Route::post('create-account', 'Api\Signup\GuestApiController@signupCreateAccount');
    });

    Route::group(['prefix' => 'signup-seller'], function ($router) {
            //Sellers Info
            //step 1 - create business
            Route::post('business-info', 'Api\SellersAccount\CreateBusinessController@create');
            //step 2 - create sellers account
            Route::post('sellers-info', 'Api\SellersAccount\CreatePrimaryContactsController@create');
            //step 3 - payment info
            Route::post('payment-info', 'Api\SellersAccount\CreatePaymentInfoController@create');
    });

});
