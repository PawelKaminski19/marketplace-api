<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersCustomersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('users_customers', function (Blueprint $table) {
             $table->bigInteger('user_id')->unsigned();
             $table->bigInteger('customer_id')->unsigned();
             $table->primary(['user_id','customer_id']);
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('users_customers');
     }
}
