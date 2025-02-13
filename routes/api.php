<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$entitiesList = [
    'Brands', 'Categories', 'Clients', 'Domains','Guests', 'Passwords','Permissions', 'Products', 'Roles', 'Languages',
    'SettingsUploads', 'Signup', 'Translations', 'Tags', 'Uploads', 'Users', 'UsersLogin', 'Shops', 'Websites',
    'VariantGroups', 'Variant'
];

foreach ($entitiesList as $element) {
    include(dirname(__FILE__) . '/api/' . $element .'Routes.php');
}


Route::group(['middleware' => 'api'], function ($router) {

    Route::get('country', 'Api\Country\CountryController@index');
    Route::get('gender', 'Api\Gender\GenderController@index');
    Route::get('constant', 'Api\Constant\ConstantController@index');

    Route::get('test-endpoint', 'Api\TestController@index');
});
