<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliatesClientsPivotTableForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates_clients', function (Blueprint $table) {
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
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
        Schema::table('affiliates_clients', function (Blueprint $table) {
            //$table->dropForeign('affiliates_clients_affiliate_id_foreign');
            //$table->dropIndex('affiliates_clients_affiliate_id_foreign');

            //$table->dropForeign('affiliates_clients_client_id_foreign');
            //$table->dropIndex('affiliates_clients_client_id_foreign');
        });
    }
}
