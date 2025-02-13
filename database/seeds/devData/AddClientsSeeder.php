<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;


class AddClientsSeeder extends Seeder
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

        $this->addClients();
    }
    private function addClients()
    {
        if (\DB::table('clients')->count() < 2) {
            \DB::statement(
                "INSERT INTO `clients` (`id`, `username`, `slug`, `softwareowner_flag`, `secure_path`, `active`, `created_at`, `updated_at`) VALUES
                            (2, 'Test Client 1', '317be0c6-ffbb-424b-bf67-86c3e5025093',  0, 0, 1, null, null),
                            (3, 'Test Client 2', 'd1d03cda-0a75-43fe-8e0a-90d62d9aa2a6', 0, 1,  1, null, null)
            ");
        }
    }

}
