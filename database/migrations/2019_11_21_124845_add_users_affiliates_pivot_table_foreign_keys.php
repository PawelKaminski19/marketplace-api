<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersAffiliatesPivotTableForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_affiliates', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_affiliates', function (Blueprint $table) {
            //$table->dropForeign('users_affiliates_user_id_foreign');
            //$table->dropIndex('users_affiliates_user_id_foreign');

            //$table->dropForeign('users_affiliates_affiliate_id_foreign');
            //$table->dropIndex('users_affiliates_affiliate_id_foreign');
        });
    }
}
