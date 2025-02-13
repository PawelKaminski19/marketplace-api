<?php

use Illuminate\Database\Seeder;

class AddUsersSeeder extends Seeder
{
    protected $defaultLanguage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $this->addUsers();
        $this->defaultLanguage = \App\Services\i18nServices\i18nLanguageService::DEFAULT_LANGUAGE;
    }

    private function addUsers()
    {

        if (\DB::table('users')->count() < 2) {
            \DB::statement(
                "INSERT INTO `users` (`id`, `softwareowner_id`, `onbehalf_id`, `userable_id`, `userable_type`, `onbehalf_time`, `onbehalf_type`, `name`, `email`, `email_verified_at`, `password`, `password_new`, `password_modified`, `remember_token`, `created_at`, `updated_at`) VALUES
                        (2, NULL, NULL, NULL, '', NULL, '', 'Client1Owner', 'owner@client1.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (3, NULL, NULL, NULL, '', NULL, '', 'Affiliate1', 'affiliate1@affiliate1.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (4, NULL, NULL, NULL, '', NULL, '', 'Affiliate2', 'affiliate2@affiliate2.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (5, NULL, NULL, NULL, '', NULL, '', 'c1w1d1', 'c1w1d1@c1w1d1.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (6, NULL, NULL, NULL, '', NULL, '', 'c1w2d2', 'c1w2d2@c1w2d2.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (7, NULL, NULL, NULL, '', NULL, '', 'c1w2d3', 'c1w2d3@c1w2d3.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (8, NULL, NULL, NULL, '', NULL, '', 'c2w1d1', 'c2w1d1@c2w1d1.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (9, NULL, NULL, NULL, '', NULL, '', 'c2w1d2', 'c2w1d2@c2w1d2.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (10, NULL, NULL, NULL, '', NULL, '', 'jacekpola', 'polajacek@gmail.com', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19'),
                        (11, NULL, NULL, NULL, '', NULL, '', 'pk', 'pawel.kaminski@polcode.net', NULL, '" . \Hash::make('password') . "', NULL, NULL, NULL, '2019-11-22 05:11:24', '2019-12-05 12:36:19');
                        ");

        }
        if (\DB::table('users_affiliates')->count() < 2) {
            \DB::statement(
                "INSERT INTO `users_affiliates` (`user_id`, `affiliate_id`) VALUES
                            (3, 1),
                            (4, 3),
                            (3, 2);
                ");
        }
        if (\DB::table('users_customers')->count() < 2) {
            \DB::statement(
                "INSERT INTO `users_customers` (`user_id`, `customer_id`) VALUES
                        (6, 1),
                        (5, 3),
                        (10, 2),
                        (11, 4);
            ");
        }
        if (\DB::table('users_employees')->count() < 2) {
            \DB::statement(
                "INSERT INTO `users_employees` (`user_id`, `employee_id`) VALUES
                        (6, 2),
                        (6, 4),
                        (6, 3),
                        (6, 1),
                        (5, 6),
                        (8, 7),
                        (9, 8);
            ");
        }
        if (\DB::table('users_brands')->count() < 2) {
            \DB::statement(
                "INSERT INTO `users_brands` (`user_id`, `brand_id`) VALUES
                        (5, 1),
                        (5, 2);
            ");
        }

    }
}
