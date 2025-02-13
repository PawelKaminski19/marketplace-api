<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AddDomainsSeeder extends Seeder
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
        $this->addDomains();
    }

    private function addDomains()
    {
        $this->addDomainsMain();
        $this->addDomains1();
        $this->addDomains2();
        $this->addDomains3();
        $this->addDomains4();
        $this->addDomains5();
        $this->addDomains6();
        $this->addDomains7();
    }

    private function addDomainsMain()
    {
        if (!Domain::query()->where('url', 'homepage.shopway.co')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'homepage.shopway.co',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'shopway.co')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'shopway.co',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'shopway.polcode.site')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'shopway.polcode.site',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'shopway-homepage.polcode.site')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'shopway-homepage.polcode.site',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }
    }

    private function addDomains1()
    {
        if (!Domain::query()->where('url', 'c1w1d1.visitset.com')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '1',
                'https' => '1',
                'url' => 'c1w1d1.visitset.com',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'c1w1d1.visitset.com.test')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '1',
                'https' => '0',
                'url' => 'c1w1d1.visitset.com.test',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }
    }

    private function addDomains2()
    {
        if (!Domain::query()->where('url', 'c1w2d2.visitset.com')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '2',
                'https' => '1',
                'url' => 'c1w2d2.visitset.com',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'c1w2d2.visitset.com.test')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '2',
                'https' => '0',
                'url' => 'c1w2d2.visitset.com.test',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }
    }

    private function addDomains3()
    {
        if (!Domain::query()->where('url', 'c1w2d3.visitset.com')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '2',
                'https' => '1',
                'url' => 'c1w2d3.visitset.com',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'c1w2d3.visitset.com.test')->first()) {
            Domain::create(['client_id' => '2',
                'website_id' => '2',
                'https' => '0',
                'url' => 'c1w2d3.visitset.com.test',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }
    }

    private function addDomains4()
    {
        if (!Domain::query()->where('url', 'c2w1d1.visitset.com')->first()) {
            Domain::create(['client_id' => '3',
                'website_id' => '3',
                'https' => '1',
                'url' => 'c2w1d1.visitset.com',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'c2w1d1.visitset.com.test')->first()) {
            Domain::create(['client_id' => '3',
                'website_id' => '3',
                'https' => '0',
                'url' => 'c2w1d1.visitset.com.test',
                'main' => '1',
                'live' => '1',
                'active' => '1']);
        }
    }

    private function addDomains5()
    {
        if (!Domain::query()->where('url', 'c2w1d2.visitset.com')->first()) {
            Domain::create(['client_id' => '3',
                'website_id' => '3',
                'https' => '1',
                'url' => 'c2w1d2.visitset.com',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

        if (!Domain::query()->where('url', 'c2w1d2.visitset.com.test')->first()) {
            Domain::create(['client_id' => '3',
                'website_id' => '3',
                'https' => '0',
                'url' => 'c2w1d2.visitset.com.test',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

    }

    private function addDomains6()
    {
        if (!Domain::query()->where('url', 'homepage.test')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'homepage.test',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

    }

    private function addDomains7()
    {
        if (!Domain::query()->where('url', 'localhost')->first()) {
            Domain::create(['client_id' => '1',
                'website_id' => '1',
                'https' => '1',
                'url' => 'localhost',
                'main' => '0',
                'live' => '1',
                'active' => '1']);
        }

    }

}
