<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AddToRootUserASuperAdminRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name','SuperAdmin')->first();
        if (!$user->hasRole('SuperAdmin')) {
            $user->assignRole('SuperAdmin');
        }
    }
}
