<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class AddEmployeesSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addEmployees();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addEmployees()
    {
        if (\DB::table('employees')->count() < 2) {
        \DB::statement(
            "INSERT INTO `employees` (`id`, `client_id`, `lang_id`, `gender_id`, `lastname`, `firstname`, `active`, `terms_accepted`, `terms_accepted_time`, `created_at`, `updated_at`) VALUES
                        (1, 1, 1, 1, 'Employee 1', 'Employee 1', 1, NULL, NULL, NULL, NULL),
                        (2, 2, 1, 1, 'Employee 2', 'Employee 2', 1, NULL, NULL, NULL, NULL),
                        (3, 2, 1, 1, 'Employee 3', 'Employee 3', 1, NULL, NULL, NULL, NULL),
                        (4, 2, 1, 1, 'Employee 4', 'Employee 4', 1, NULL, NULL, NULL, NULL),
                        
                        (5, 2, 1, 1, 'Employee c1w1d', 'Employee c1w1d1', 1, NULL, NULL, NULL, NULL),
                        (6, 2, 1, 1, 'Employee c1w2d2', 'Employee c1w2d2', 1, NULL, NULL, NULL, NULL),
                        (7, 3, 1, 1, 'Employee c2w1d1', 'Employee c2w1d1', 1, NULL, NULL, NULL, NULL),
                        (8, 3, 1, 1, 'Employee c2w1d1', 'Employee c2w1d1', 1, NULL, NULL, NULL, NULL),
                        (9, 3, 1, 1, 'Employee c2w1d1', 'Employee c2w1d1', 1, NULL, NULL, NULL, NULL);
            ");
        }
    }
}
