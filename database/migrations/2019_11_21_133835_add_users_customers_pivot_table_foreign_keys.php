<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersCustomersPivotTableForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_customers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_customers', function (Blueprint $table) {
            //$table->dropForeign('users_customers_user_id_foreign');
            //$table->dropIndex('users_customers_user_id_foreign');

            //$table->dropForeign('users_customers_customer_id_foreign');
            //$table->dropIndex('users_customers_customer_id_foreign');
        });
    }
}
