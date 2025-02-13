<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDeletedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('deleted');
            $table->softDeletes();
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('deleted');
            $table->softDeletes();
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('deleted');
            $table->softDeletes();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('deleted');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->tinyInteger('deleted')->default(0)->after('conversion_rate');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->tinyInteger('deleted')->default(0)->nullable()->after('active');
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->tinyInteger('deleted')->default(0)->nullable()->after('active');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dateTime('deleted')->nullable()->after('terms_accepted_time');
        });
    }
}
