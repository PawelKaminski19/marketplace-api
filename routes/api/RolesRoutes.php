<?php
Route::group(['middleware' => ['api','jwt.verify'],'prefix' => 'roles' ], function ($router) {
       //core roles
       Route::get('core', 'Api\Admin\RolesAndPermissions\RoleController@getCore');
       Route::post('core', 'Api\Admin\RolesAndPermissions\RoleController@storeCore');

       //update CORE roles names
       Route::put('{roleId}/core', 'Api\Admin\RolesAndPermissions\RoleController@updateCore');
       //update roles names
       Route::put('{roleId}/clients/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@updateByClient');

       //roles by clients
       Route::get('clients/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@getByClient');
       Route::get('clients/{clientId}/{name}', 'Api\Admin\RolesAndPermissions\RoleController@getByClientAndByName');
       Route::post('clients/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@storeByClient');

       //assign role to user
       Route::put('{roleId}/users/{userId}/clients/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@assignRoleToUser');
       //revoke role from user
       Route::delete('{roleId}/users/{userId}/clients/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@revokeRoleFromUser');

       //all roles
       Route::get('/', 'Api\Admin\RolesAndPermissions\RoleController@index');
       Route::get('delete/{clientId}', 'Api\Admin\RolesAndPermissions\RoleController@delete');
});
