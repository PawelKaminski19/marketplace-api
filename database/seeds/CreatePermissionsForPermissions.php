<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class CreatePermissionsForPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $perm = \DB::table('permissions')->where('name','create permission')->count();
        if ($perm == 0) {
            Permission::create(['name' => 'create permission']);
        }
        $perm = \DB::table('permissions')->where('name','read permission')->count();
        if ($perm == 0) {
            Permission::create(['name' => 'read permission']);
        }
        $perm = \DB::table('permissions')->where('name','update permission')->count();
        if ($perm == 0) {
            Permission::create(['name' => 'update permission']);
        }
        $perm = \DB::table('permissions')->where('name','delete permission')->count();
        if ($perm == 0) {
            Permission::create(['name' => 'delete permission']);
        }

        //Super Admin Role update
        $role = Role::where(['name' => 'SuperAdmin'])->first();
        $role->givePermissionTo(Permission::all());
    }
}
