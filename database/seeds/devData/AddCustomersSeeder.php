<?php

use Illuminate\Database\Seeder;

class AddCustomersSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addCustomers();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addCustomers()
    {

        if (\DB::table('customers')->count() < 2) {
            \DB::statement(
                "INSERT INTO `customers` (`id`, `client_id`, `website_id`, `gender_id`, `lang_id`, `group_id`, `company`, `firstname`, `lastname`, `phone`, `digest_hash`,
                             `accepted_terms`, `newsletter_sub`, `newsletter_optin`, `newsletter_unsub`, `note`, `is_guest`, `active`, `terms_accepted`, `terms_accepted_time`, `created_at`, `updated_at`) VALUES
                            (1, 3, 1, 1, 1, NULL, 'Company A', 'Customer A firstname', 'Customer A Lastname', '123456789', 'cce492688e30ea1eeaaa637df7e44eed', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
                            (2, 2, 2, 1, 1, NULL, 'Company B', 'Customer B firstname', 'Customer B Lastname', '+491624131313', '1bd1874d21975388fd36832914df11c4', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL,  NULL, NULL),
                            (3, 2, 3, 1, 1, NULL, 'Company C', 'Customer C firstname', 'Customer C Lastname', '123456789', 'feb698d5b02b1026cb34bb077b1a6b83', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
                            (4, 3, 4, 1, 1, NULL, 'Company D', 'Customer D firstname', 'Customer D Lastname', '+48509530134', 'asd21asda534sdvd3244df', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);
                ");
        }
    }
}
