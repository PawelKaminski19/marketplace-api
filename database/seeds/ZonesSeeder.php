<?php

use Illuminate\Database\Seeder;

class ZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zones = \DB::table('tax_rules')->count();
        if ($zones < 8) {
            \DB::statement("
                INSERT INTO `zones` (`id`, `name`, `active`) VALUES
                (1, 'Europe', 1),
                (2, 'Europe (non-EU)', 1),
                (3, 'North America', 1),
                (4, 'South America', 1),
                (5, 'Central America/Antilla', 1),
                (6, 'Africa', 1),
                (7, 'Asia', 1),
                (8, 'Oceania', 1);
            ");
        }
    }
}
