<?php

use Illuminate\Database\Seeder;

class AddSettingsUploadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('settings_uploads')->count() < 2) {
            //adding some clients id=1 setting uploads
            \DB::statement(
                "INSERT INTO `settings_uploads` (`client_id`, `website_id`, `core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', '2', '0', 'App\\\\Models\\\\Product', 'lists', '1600, 800, 320','25','75','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`client_id`, `website_id`, `core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', '2', '0', 'App\\\\Models\\\\Product', 'profile', '320','1','75','7');
                ");
            //adding some clients id=2 setting uploads
            \DB::statement(
                "INSERT INTO `settings_uploads` (`client_id`,  `core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('2',  '0', 'App\\\\Models\\\\Product', 'lists', '1600, 800, 320','25','75','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`client_id`,  `core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('2',  '0', 'App\\\\Models\\\\Product', 'profile', '640','1','75','7');
                ");


            //adding some core setting uploads
            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Website', 'logo', '640','25','75','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Website', 'logo', '1600, 800, 320','1','75','7');
                ");

            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Product', 'lists', '600, 80, 32','25','55','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Product', 'profile', '800','1','55','7');
                ");

            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Brand', 'logo', '640','25','75','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Brand', 'logo', '1600, 800, 320','1','75','7');
                ");

            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Category', 'logo', '640','25','75','7');
                ");
            \DB::statement(
                "INSERT INTO `settings_uploads` (`core`, `model`, `type`, `sizes`, `max_allowed_files`, `jpg_quality`, `png_quality`) VALUES
                            ('1', 'App\\\\Models\\\\Category', 'logo', '1600, 800, 320','1','75','7');
                ");

        }
    }
}
