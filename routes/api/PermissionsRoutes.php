<?php
Route::group(['middleware' => ['api','jwt.verify'],'prefix' => 'permissions' ], function ($router) {
        Route::get('by-name/{roleName}', 'Api\Admin\PermissionController@findByName');
        Route::get('/', 'Api\Admin\RolesAndPermissions\PermissionController@index');
        //assign permission to role
        Route::put('{permissionId}/roles/{roleId}', 'Api\Admin\RolesAndPermissions\PermissionController@assignPermissionsToRole');
        //revoke permission to role
        Route::delete('{permissionId}/roles/{roleId}', 'Api\Admin\RolesAndPermissions\PermissionController@revokePermissionsFromRole');
});
