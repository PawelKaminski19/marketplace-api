<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class CreateRolesPermissionsAndSuperAdmin extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsList = ['category', 'client', 'product', 'role', 'setting', 'upload', 'website',  'variant group', 'variant'];

        foreach ($permissionsList as $element) {
            $perm = \DB::table('permissions')->where('name', 'create ' . $element)->count();
            if ($perm == 0) {
                Permission::create(['name' => 'create ' . $element]);
            }
            $perm = \DB::table('permissions')->where('name', 'read ' . $element)->count();
            if ($perm == 0) {
                Permission::create(['name' => 'read ' . $element]);
            }
            $perm = \DB::table('permissions')->where('name', 'update ' . $element)->count();
            if ($perm == 0) {
                Permission::create(['name' => 'update ' . $element]);
            }
            $perm = \DB::table('permissions')->where('name', 'delete ' . $element)->count();
            if ($perm == 0) {
                Permission::create(['name' => 'delete ' . $element]);
            }
        }

        // create permissions for roles
        $role = \DB::table('roles')->where('name', 'SuperAdmin')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'SuperAdmin', 'core' => 1]);
            $role->givePermissionTo(Permission::all());
        }

        $role = \DB::table('roles')->where('name', 'Logistician')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Logistician']);
            $role->givePermissionTo(Permission::all());
            
            //Roles creating
            $role = Role::create(['client_id'=>1, 'name' => 'Logistician']);
            $role->givePermissionTo(Permission::all());

            //Roles creating
            $role = Role::create(['client_id'=>2, 'name' => 'Logistician']);
            $role->givePermissionTo(Permission::all());
        }

        $role = \DB::table('roles')->where('name', 'Translator')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Translator']);
            $role->givePermissionTo(Permission::all());
        }
        $role = \DB::table('roles')->where('name', 'Salesman')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Salesman']);
            $role->givePermissionTo(Permission::all());
        }
        $role = \DB::table('roles')->where('name', 'Tester')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Tester']);
            $role->givePermissionTo(Permission::all());
        }
        $role = \DB::table('roles')->where('name', 'Redactor')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Redactor']);
            $role->givePermissionTo(Permission::all());
        }
        $role = \DB::table('roles')->where('name', 'Personnel')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Personnel']);
            $role->givePermissionTo(Permission::all());

            //Roles creating
            $role = Role::create(['client_id'=>1, 'name' => 'Personnel']);
            $role->givePermissionTo(Permission::all());

            //Roles creating
            $role = Role::create(['client_id'=>2, 'name' => 'Personnel']);
            $role->givePermissionTo(Permission::all());

            //Roles creating
            $role = Role::create(['client_id'=>3, 'name' => 'Personnel']);
            $role->givePermissionTo(Permission::all());
        }
        $role = \DB::table('roles')->where('name', 'Admin')->count();
        if ($role == 0) {
            //Roles creating
            $role = Role::create(['name' => 'Admin', 'core' => 1]);
            $role->givePermissionTo(Permission::all());
        }

    }
}
