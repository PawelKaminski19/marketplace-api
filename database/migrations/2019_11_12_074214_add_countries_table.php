<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('zone_id')->unsigned();
            $table->string('title',128);
            $table->string('locale',5)->nullable();
            $table->string('iso_code',3)->nullable();
            $table->smallInteger('call_prefix')->unsigned()->nullable();
            $table->smallInteger('contains_states')->unsigned()->nullable();
            $table->smallInteger('need_zip_code')->unsigned()->nullable();
            $table->string('zip_code_format',12);
            $table->smallInteger('display_tax_label')->unsigned();
            $table->tinyInteger('active')->unsigned()->nullable();
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
        Schema::dropIfExists('countries');
    }
}
