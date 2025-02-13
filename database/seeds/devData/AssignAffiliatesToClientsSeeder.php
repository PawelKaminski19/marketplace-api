<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AssignAffiliatesToClientsSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->assignAffiliatesToClients();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function assignAffiliatesToClients()
    {
       
        if (\DB::table('affiliates_clients')->count() < 1) {
            \DB::statement(
                "INSERT INTO `affiliates_clients` (`affiliate_id`, `client_id`) VALUES
                            (1, 2),
                            (1, 3);
                ");
        }

    }
}
