<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignKeysCoinstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign('affiliates_lang_id_foreign');
            $table->dropIndex('affiliates_lang_id_foreign');
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
            $table->bigInteger('website_id')->unsigned()->nullable(false)->change();
            $table->foreign('website_id')->references('id')->on('websites');
        });

        Schema::table('customers', function (Blueprint $table) {

            $table->bigInteger('lang_id')->unsigned()->nullable(false)->change();

            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
        Schema::table('softwareowners', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        Schema::table('affiliates', function (Blueprint $table) {

            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
    }
}
