<?php

use Illuminate\Database\Seeder;

class AddGendersTableInitialData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = \DB::table('currencies')->count();
        if ($genders < 2) {
            $male = \App\Models\Gender::create();

            //Add EN translations
            $male->translateOrNew('en')->title = 'male';
            $male->save();

            $female = \App\Models\Gender::create();
            $female->translateOrNew('en')->title = 'female';
            $female->save();
        }
    }
}
