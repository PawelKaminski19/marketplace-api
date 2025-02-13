<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model', 255)->nullable();
            $table->bigInteger('model_id')->unsigned()->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->string('name', 255)->nullable();
            $table->string('organization', 100)->nullable();
            $table->string('organization_title', 100)->nullable();
            $table->string('firstname', 100)->nullable();
            $table->string('middlename', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('street_nr', 100)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('address3', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 7)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('mobile2', 20)->nullable();
            $table->string('url', 255)->nullable();
            $table->tinyInteger('map_zoom')->unsigned()->nullable();
            $table->string('map_lat', 12)->nullable();
            $table->string('map_lng', 12)->nullable();
            $table->string('streetview_lat', 12)->nullable();
            $table->string('streetview_lng', 12)->nullable();
            $table->tinyInteger('standard')->unsigned()->nullable();
            $table->tinyInteger('active')->unsigned()->nullable();
            $table->tinyInteger('deleted')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
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
        Schema::table('locations', function(Blueprint $table){
            //$table->dropForeign(['address_id']);
        });

        Schema::table('addresses', function(Blueprint $table){
            $table->dropForeign(['country_id']);
            $table->dropForeign(['gender_id']);
        });

        Schema::dropIfExists('addresses');
    }
}
