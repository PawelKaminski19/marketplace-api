<?php
/** generating phone code */
Route::get('password-reset/code/{hash}', 'Api\Login\PasswordReset\PasswordResetCodeController@code'); 
/** phone code verification */
Route::post('password-reset/hash/{hash}', 'Api\Login\PasswordReset\PasswordResetFormController@form');
/** confirming password update */
Route::post('password-reset/update/{hash}', 'Api\Login\PasswordReset\PasswordUpdateController@update');
/** sending email */
Route::get('password-reset/{email}/{websiteId?}', 'Api\Login\PasswordReset\PasswordResetRequestController@send');
