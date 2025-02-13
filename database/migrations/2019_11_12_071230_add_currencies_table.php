<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32);
            $table->string('iso_code',3)->default(0);
            $table->string('iso_code_num',3)->default(0);
            $table->string('sign',8);
            $table->tinyInteger('blank')->default(0);
            $table->tinyInteger('format')->default(0);
            $table->tinyInteger('decimals')->default(1);
            $table->decimal('conversion_rate',13,6);
            $table->tinyInteger('deleted')->default(0);
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('currencies');
    }
}
