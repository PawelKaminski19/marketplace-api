<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_type')->unsigned()->nullable();
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->string('uuid', 1024)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('ceos', 75)->nullable();
            $table->string('register_court', 75)->nullable();
            $table->string('register_nr', 75)->nullable();
            $table->string('tax_id_nr', 25)->nullable();
            $table->string('vat_number', 25)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
