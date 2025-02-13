<?php

use Illuminate\Database\Seeder;
use App\Services\SeederServices\ProductDataSeederService;

class AddWebsiteProductCategoriesSeeder extends Seeder
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
        $this->addProductCategories();
    }

    private function addProductCategories()
    {

    }
}
