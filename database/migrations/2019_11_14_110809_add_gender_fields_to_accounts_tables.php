<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderFieldsToAccountsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('gender_id')->unsigned()->nullable()->after('lang_id');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
        });

        Schema::table('softwareowners', function (Blueprint $table) {
            $table->bigInteger('gender_id')->unsigned()->nullable()->after('lang_id');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
        });

        Schema::table('affiliates', function (Blueprint $table) {
            $table->bigInteger('gender_id')->unsigned()->nullable()->after('lang_id');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_gender_id_foreign');
            $table->dropColumn('gender_id');
        });
        Schema::table('softwareowners', function (Blueprint $table) {
            $table->dropForeign('softwareowners_gender_id_foreign');
            $table->dropColumn('gender_id');
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign('affiliates_gender_id_foreign');
            $table->dropColumn('gender_id');
        });
    }
}
