<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('locations', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->bigInteger('address_id')->unsigned()->nullable();
            // $table->bigInteger('company_id')->unsigned()->nullable();
             $table->string('name', 255)->nullable();
             $table->string('title', 255)->nullable();
             $table->string('subtitle', 255)->nullable();
             $table->tinyInteger('active')->unsigned()->nullable();
             $table->timestamps();
         });

         Schema::table('locations', function (Blueprint $table) {
             $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
             //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
         });
     }
     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('locations');
     }
}
