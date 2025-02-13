<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsFieldsToAccountsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->tinyInteger('terms_accepted')->unsigned()->nullable()->after('active');
            $table->dateTime('terms_accepted_time')->nullable()->after('terms_accepted');
        });

        Schema::table('softwareowners', function (Blueprint $table) {
            $table->tinyInteger('terms_accepted')->unsigned()->nullable()->after('active');
            $table->dateTime('terms_accepted_time')->nullable()->after('terms_accepted');
        });

        Schema::table('affiliates', function (Blueprint $table) {
            $table->tinyInteger('terms_accepted')->unsigned()->nullable()->after('active');
            $table->dateTime('terms_accepted_time')->nullable()->after('terms_accepted');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->tinyInteger('terms_accepted')->unsigned()->nullable()->after('active');
            $table->dateTime('terms_accepted_time')->nullable()->after('terms_accepted');
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
            $table->dropColumn('terms_accepted');
            $table->dropColumn('terms_accepted_time');
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropColumn('terms_accepted');
            $table->dropColumn('terms_accepted_time');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('terms_accepted');
            $table->dropColumn('terms_accepted_time');
        });
    }
}
