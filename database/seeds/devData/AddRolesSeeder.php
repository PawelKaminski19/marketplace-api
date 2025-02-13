<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AddRolesSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addRoles();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addRoles()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Super Admin Role update
        $role = Role::where(['name' => 'SuperAdmin'])->first();

        //Super Admin Role update
        $user = User::where(['email' => 'owner@client1.com'])->first();
        $user->assignRole($role);

        
        $personnel = Role::where(['client_id' => 1,'name' => 'Personnel'])->first();
        $user = User::where(['email' => 'c1w1d1@c1w1d1.com'])->first();
        $user->assignRole($personnel);

        
        $personnel = Role::where(['client_id' => 2,'name' => 'Personnel'])->first();
        $user = User::where(['email' => 'c1w1d1@c1w1d1.com'])->first();
        $user->assignRole($personnel);

        


        $personnel = Role::where(['client_id' => 1,'name' => 'Personnel'])->first();
        $user = User::where(['email' => 'c1w2d2@c1w2d2.com'])->first();
        $user->assignRole($personnel);

        
        $personnel = Role::where(['client_id' => 2,'name' => 'Personnel'])->first();
        $user = User::where(['email' => 'c1w2d2@c1w2d2.com'])->first();
        $user->assignRole($personnel);


        $personnel = Role::where(['client_id' => 3,'name' => 'Personnel'])->first();
        
        $user = User::where(['email' => 'c2w1d1@c2w1d1.com'])->first();
        $user->assignRole($personnel);
        
        $user = User::where(['email' => 'c2w1d2@c2w1d2.com'])->first();
        $user->assignRole($personnel);
        
    }
}
