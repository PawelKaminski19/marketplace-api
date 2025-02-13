<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysCoinstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->bigInteger('website_id')->unsigned()->nullable()->change();
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('set null');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->bigInteger('lang_id')->unsigned()->nullable()->change();
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('set null');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('lang_id')->references('id')->on('langs');
        });

        Schema::table('softwareowners', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('lang_id')->references('id')->on('langs');
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->foreign('lang_id')->references('id')->on('langs');
        });
        Schema::table('guests', function (Blueprint $table) {


            $table->foreign('website_id')->references('id')->on('websites')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('set null');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
            $table->foreign('phone_country_id')->references('id')->on('countries')->onDelete('set null');


        });

        Schema::table('customers_groups', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

        });

        Schema::table('clients_brands', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_website_id_foreign');
            $table->dropIndex('categories_website_id_foreign');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_gender_id_foreign');
            $table->dropForeign('customers_lang_id_foreign');

            $table->dropIndex('customers_gender_id_foreign');
            $table->dropIndex('customers_lang_id_foreign');

        });
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_lang_id_foreign');
            $table->dropIndex('employees_lang_id_foreign');

        });
        Schema::table('softwareowners', function (Blueprint $table) {
            $table->dropForeign('softwareowners_client_id_foreign');
            $table->dropIndex('softwareowners_client_id_foreign');
            $table->dropForeign('softwareowners_lang_id_foreign');
            $table->dropIndex('softwareowners_lang_id_foreign');

        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign('affiliates_lang_id_foreign');
            $table->dropIndex('affiliates_lang_id_foreign');

        });
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign('guests_lang_id_foreign');
            $table->dropForeign('guests_website_id_foreign');
            $table->dropForeign('guests_currency_id_foreign');
            $table->dropForeign('guests_country_id_foreign');
            $table->dropForeign('guests_customer_id_foreign');
            $table->dropForeign('guests_phone_country_id_foreign');

            $table->dropIndex('guests_lang_id_foreign');
            $table->dropIndex('guests_website_id_foreign');
            $table->dropIndex('guests_currency_id_foreign');
            $table->dropIndex('guests_country_id_foreign');
            $table->dropIndex('guests_customer_id_foreign');
            $table->dropIndex('guests_phone_country_id_foreign');


        });


        Schema::table('customers_groups', function (Blueprint $table) {
            //$table->dropForeign('customers_groups_customer_id_foreign');
            //$table->dropIndex('customers_groups_customer_id_foreign');
            //$table->dropForeign('customers_groups_group_id_foreign');
            //$table->dropIndex('customers_groups_group_id_foreign');
        });
        Schema::table('clients_brands', function (Blueprint $table) {
                $table->dropForeign('clients_brands_client_id_foreign');
                $table->dropIndex('clients_brands_client_id_foreign');
                $table->dropForeign('clients_brands_brand_id_foreign');
                $table->dropIndex('clients_brands_brand_id_foreign');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign('countries_currency_id_foreign');
            $table->dropForeign('countries_zone_id_foreign');
            $table->dropIndex('countries_currency_id_foreign');
            $table->dropIndex('countries_zone_id_foreign');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('groups_client_id_foreign');
            $table->dropIndex('groups_client_id_foreign');
        });
    }
}
