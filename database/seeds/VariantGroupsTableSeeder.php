<?php

use App\Models\VariantGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Uncomment if large seed is needed
//        $values = \App\Services\SeederServices\VariantGroupsSeederService::getVariantGroupSeederData();

        $values = $this->getSeedData();

        foreach ($values as $value) {
            $variantGroup = new VariantGroup();

            $variantGroup->fill($value);

            $variantGroup->save();
        }
    }

    /**
     * Returns array with seed combinations
     * @return array
     */
    private function getSeedData(): array
    {
        return [
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni 02 Ausführung',
                'title' => 'Ausführung',
                'subtitle' => NULL,
                'position' => 1,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni 03 Polster',
                'title' => 'Polster',
                'subtitle' => NULL,
                'position' => 162,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni 01 Größe',
                'title' => 'Größe',
                'subtitle' => NULL,
                'position' => 163,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Tischplatte',
                'title' => 'Tischplatte',
                'subtitle' => NULL,
                'position' => 166,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Farbe Gestell',
                'title' => 'Farbe Gestell',
                'subtitle' => NULL,
                'position' => 167,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Farbe',
                'title' => 'Farbe',
                'subtitle' => NULL,
                'position' => 170,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Korpus',
                'title' => 'Korpus',
                'subtitle' => NULL,
                'position' => 171,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Sitzpolster',
                'title' => 'Sitzpolster',
                'subtitle' => NULL,
                'position' => 172,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni Sitzpolster',
                'title' => 'Sitzpolster',
                'subtitle' => NULL,
                'position' => 173,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29',
            ],
            [
                'client_id' => 1,
                'website_id' => NULL,
                'name' => 'Gervasoni X Füße',
                'title' => 'Füße',
                'subtitle' => NULL,
                'position' => 154,
                'created_at' => '2019-06-17 13:49:29',
                'updated_at' => '2019-06-17 13:49:29'
            ]
        ];
    }
}
