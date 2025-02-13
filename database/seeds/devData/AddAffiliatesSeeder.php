<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AddAffiliatesSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->affiliates();
        
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }
    private function affiliates()
    {
        if (\DB::table('affiliates')->count() < 2) {
            \DB::statement(
                "INSERT INTO `affiliates` (`id`, `lang_id`, `gender_id`, `lastname`, `firstname`, `uuid`, `active`, `terms_accepted`, `terms_accepted_time`, `created_at`, `updated_at`) VALUES
                            (1, 1, 1, 'Affiliate 1 Lastname', 'Affiliate 1 Firstname', '967f82dc-5d4f-481e-b4df-71558ce1b15c', 1, NULL, NULL, NULL, NULL),
                            (2, 1, 1, 'Affiliate 2 Lastname', 'Affiliate 2 Firstname', '4ec450a4-8db0-471f-b752-df9488cacced', 1, NULL, NULL, NULL, NULL),
                            (3, 1, 1, 'Affiliate 3 Lastname', 'Affiliate 3 Firstname', '98c32a73-9847-4df2-b33a-65a325e68213', 1, NULL, NULL, NULL, NULL);
            ");
        }
    }
   
}
