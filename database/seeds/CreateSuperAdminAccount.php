<?php

use Illuminate\Database\Seeder;

class CreateSuperAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \DB::table('users')->where('name','SuperAdmin')->count();
        if ($user == 0) {
            DB::table('users')->insert([
               'name' => 'SuperAdmin',
               'email' => 'admin@admin.local',
               'password' => bcrypt('password'),
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now(),
           ]);
        }


    }
}
