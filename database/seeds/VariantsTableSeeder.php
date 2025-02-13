<?php


use App\Models\Variant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Uncomment if large seed is needed
        //$values = \App\Services\SeederServices\VariantSeederService::getVariantSeederData();

        $values = $this->getSeederData();

        foreach ($values as $value) {
            $variant = new Variant();

            $variant->fill($value);

            $variant->save();
        }
    }

    private function getSeederData()
    {
        return [
            [
                'variant_group_id' => 1,
                'title' => 'Buche lackiert, grau',
                'subtitle' => '',
                'position' => 30,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 1,
                'title' => 'Buche lackiert, schieferblau',
                'subtitle' => '',
                'position' => 31,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 1,
                'title' => 'Buche lackiert, schwarz',
                'subtitle' => '',
                'position' => 32,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 2,
                'title' => 'mit Polster und  Bezug in Stoff-Kat. B',
                'subtitle' => 'Alle Gervasoni Stoffe der Kategorie B',
                'position' => 1,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 2,
                'title' => 'mit Polster und Bezug in Stoff-Kat. C',
                'subtitle' => 'Alle Gervasoni Stoffe der Kategorie C',
                'position' => 2,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 2,
                'title' => 'mit Polster und  Bezug in Stoff-Kat. D',
                'subtitle' => 'Alle Gervasoni Stoffe der Kategorie D',
                'position' => 3,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 3,
                'title' => '200 x 100 cm',
                'subtitle' => '',
                'position' => 0,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 3,
                'title' => '240 x 100 cm',
                'subtitle' => '',
                'position' => 1,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 3,
                'title' => '150 x 150 cm',
                'subtitle' => '',
                'position' => 7,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 6,
                'title' => 'weiß',
                'subtitle' => '',
                'position' => 0,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ],
            [
                'variant_group_id' => 6,
                'title' => 'grau',
                'subtitle' => '',
                'position' => 1,
                'optional' => 0,
                'delivery_days' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2019-06-17 13:21:44',
                'updated_at' => '2019-06-17 13:21:44'
            ]
        ];
    }
}
