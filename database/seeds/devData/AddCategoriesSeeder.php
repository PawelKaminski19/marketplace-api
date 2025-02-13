<?php

use Illuminate\Database\Seeder;

class AddCategoriesSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addCategories();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addCategories()
    {
        $categories = \DB::table('categories')->count();

        if ($categories < 2) {
            $this->createCategories();
        }

    }

    private function createCategories(): void
    {
        \App\Models\Category::unguard();

        $websites = \App\Models\Website::all();
        $id = 1;
        foreach($websites as $website) {
            $values = [
                [
                    'id' => $id,
                    'website_id' => $website->id,
                    'parent_id' => null,
                    'depth' => 0,
                    'root' => 1,
                    'position' => 0,
                    'path' => '',
                    'slug' => 'root',
                    'url' => 'root',
                    'title' => 'Root',
                    'description' => '',
                    'meta_title' => '',
                    'meta_description' => '',
                    'meta_keywords' => '',
                    'active' => 1,
                    'created_at' => '2015-08-15 18:02:14',
                    'updated_at' => '2015-08-15 18:02:14',
                    'image' => 'sample1.jpg'
                ],
                [
                    'id' => $id + 1,
                    'website_id' => $website->id,
                    'parent_id' => $id,
                    'depth' => 1,
                    'root' => $id,
                    'position' => 10,
                    'path' => 'serien-'.$id,
                    'slug' => 'up-'.$id,
                    'url' => 'up-'.$id,
                    'title' => 'Up '.$id,
                    'description' => ($id + 1).'<p>\"Beinfreiheit\" für Sessel, Stuhl oder Bett - die Gervasoni UP Polstermöbel tragen die Hussen kurz!</p>',
                    'meta_title' => ($id + 1).'Gervasoni Up - die gesamte Kollektion italienischer Möbel',
                    'meta_description' => ($id + 1).'Entdecken Sie die Gervasoni Up Kollektion in unserem Shop und bestellen Sie noch heute versandkostenfrei. Jetzt Rabatte sichern und italienische Möbel günstig kaufen.',
                    'meta_keywords' => '',
                    'active' => 1,
                    'created_at' => '2016-01-15 14:03:13',
                    'updated_at' => '2019-08-12 12:46:39',
                    'image' => 'sample2.jpg'
                ],
                [
                    'id' => $id + 2,
                    'website_id' => $website->id,
                    'parent_id' => ($id + 1),
                    'depth' => 2,
                    'root' => $id,
                    'position' => 4,
                    'path' => 'serien-'.$id.'/next',
                    'slug' => 'ghost-'.$id,
                    'url' => 'ghost-'.$id,
                    'title' => 'Ghost '.$id,
                    'description' => ($id + 2).'<p>Dank der leicht zu wechselnen Hussen wird aus jedem GHOST Polstermöbel Ihr persönliches Lieblingsstück!</p>',
                    'meta_title' => ($id + 2).'Gervasoni Ghost - Italienische Designermöbel online kaufen',
                    'meta_description' => ($id + 2).'Entdecken Sie die Gervasoni Ghost Kollektion in unserem Onlineshop. Versandkostenfreie Lieferung und attraktive Rabatte warten auf Sie.',
                    'meta_keywords' => '',
                    'active' => 0,
                    'created_at' => '2016-01-15 14:03:13',
                    'updated_at' => '2019-08-12 12:46:39',
                    'image' => 'sample3.png'
                ]
            ];

            foreach ($values as $value) {
                $image = false;
                if (isset($value['image'])) {
                    $image = $value['image'];
                    unset($value['image']);
                }

                $category = new \App\Models\Category();
                $category->fill($value);
                $category->save();
                $value['path'] .= '-en';
                $value['url'] .= '-en';
                $value['slug'] .= '-en';
                $value['title'] .= ' ENq';
                $value['meta_title'] .= ' ENw';
                $value['description'] .= ' ENe';
                $value['meta_description'] .= ' ENr';
                $value['meta_keywords'] .= ' ENt';
                $category->translateOrNew('en')->fill(\Illuminate\Support\Arr::only($value, (new \App\Models\Translatable\CategoryTranslation())->getFillable()));
                $category->save();

                if ($image) {
                    $this->sendToS3($category, $image);
                }
            }

            $id += 3;
        }
    }


    /**
     *
     * @param \App\Models\Category $category
     * @param string $imageName
     */
    private function sendToS3($category, $imageName)
    {
        $user = \App\Models\User::find(1);
        $file = new \Illuminate\Http\UploadedFile(database_path('seeds/devData/uploads/'.$imageName), $imageName);

        $data = [
            'data' => [
                'filepond' => $file,
                'model' => $category
            ],
            'clientId' => 2,
            'settingId' => 11,
            'customName' => null,
        ];

        $genericUpload = new \App\Services\UploadServices\GenericUpload($data, $user);
        $genericUpload->process();
    }
}
