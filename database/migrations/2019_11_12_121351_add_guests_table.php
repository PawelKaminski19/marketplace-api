<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid',128);
            $table->string('session',128);
            $table->bigInteger('website_id')->unsigned()->nullable();
            $table->bigInteger('domain_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('employee_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('currency_id')->unsigned()->nullable();
            $table->bigInteger('lang_id')->unsigned()->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->bigInteger('phone_country_id')->unsigned()->nullable();
            $table->tinyInteger('email_is_verified')->nullable()->default(0);
            $table->timestamp('email_is_verified_at')->nullable();

            $table->string('firstname',128)->nullable();
            $table->string('lastname',128)->nullable();
            $table->string('email',128)->nullable();
            $table->string('phone',128)->nullable();
            $table->string('accept_language',8)->nullable();
            $table->string('ip',16)->nullable();
            $table->string('operating_system',64)->nullable();
            $table->string('web_browser',64)->nullable();

            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
