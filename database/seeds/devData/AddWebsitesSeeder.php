<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AddWebsitesSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;

        $this->createWebsites();

    }

    private function createWebsites(): void
    {
        $values = [
            [
                'id' => 1,
                'client_id' => 1,
                'category_id' => null,
                'slug' => \App\Services\WebsiteServices\WebsiteService::slug('shopway.co'),
                'url' => 'shopway.co',
                'title' => 'Website A',
                'subtitle' => 'Website A subtitle',
                'logotitle' => NULL,
                'logosubtitle' => NULL,
                'meta_title' => 'title1',
                'meta_description' => 'description1',
                'meta_keywords' => 'keywords1',
                'layout' => NULL,
                'active' => 1
            ],
            [
                'id' => 2,
                'client_id' => 2,
                'category_id' => null,
                'slug' => \App\Services\WebsiteServices\WebsiteService::slug('websiteBURL-test.com'),
                'url' => 'websiteBURL-test.com',
                'title' => 'Website B',
                'subtitle' => 'Website B subtitle',
                'logotitle' => NULL,
                'logosubtitle' => NULL,
                'meta_title' => 'title2',
                'meta_description' => 'description2',
                'meta_keywords' => 'keywords2',
                'layout' => NULL,
                'active' => 1
            ],
            [
                'id' => 3,
                'client_id' => 2,
                'category_id' => null,
                'slug' => \App\Services\WebsiteServices\WebsiteService::slug('websiteCURL'),
                'url' => 'websiteCURL',
                'title' => 'Website C',
                'subtitle' => 'Website C subtitle',
                'logotitle' => NULL,
                'logosubtitle' => NULL,
                'meta_title' => 'title3',
                'meta_description' => 'description3',
                'meta_keywords' => 'keywords3',
                'layout' => NULL,
                'active' => 1
            ],
            [
                'id' => 4,
                'client_id' => 3,
                'category_id' => null,
                'slug' => \App\Services\WebsiteServices\WebsiteService::slug('websiteDURL'),
                'url' => 'websiteDURL',
                'title' => 'Website D',
                'subtitle' => 'Website D subtitle',
                'logotitle' => NULL,
                'logosubtitle' => NULL,
                'meta_title' => 'title4',
                'meta_description' => 'description4',
                'meta_keywords' => 'keywords4',
                'layout' => NULL,
                'active' => 1
            ],
            [
                'id' => 5,
                'client_id' => 3,
                'category_id' => null,
                'slug' => \App\Services\WebsiteServices\WebsiteService::slug('websiteEURL'),
                'url' => 'websiteEURL',
                'title' => 'Website E',
                'subtitle' => 'Website E subtitle',
                'logotitle' => NULL,
                'logosubtitle' => NULL,
                'meta_title' => 'title5',
                'meta_description' => 'description5',
                'meta_keywords' => 'keywords5',
                'layout' => NULL,
                'active' => 1
            ]
        ];

        $allBrands = \App\Models\Brand::limit(10)->get();

        foreach ($values as $value) {
            if ( (new \App\Models\Website())->newQuery()->find($value['id']) ) continue;

            $website = new \App\Models\Website();
            $website->fill($value);
            $website->save();
            $value['subtitle'] .= '-en';
            $value['title'] .= '-en';

            $value['meta_title'] .= '-en';
            $value['meta_description'] .= '-en';
            $value['meta_keywords'] .= '-en';
            $website->translateOrNew('en')->fill(\Illuminate\Support\Arr::only($value, (new \App\Models\Translatable\WebsiteTranslation())->getFillable()));
            $website->save();

            foreach($allBrands as $k => $brand) {
                $website->brands()->attach($brand);
            }
        }
    }
}
