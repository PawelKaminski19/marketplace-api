<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',64);
            $table->string('sign',64);
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->string('is_code',2);
            $table->string('language_code',5);
            $table->string('date_format_lite',32)->default('Y-m-d');
            $table->string('date_format_full',32)->default('Y-m-d H:i:s');
            $table->tinyInteger('is_rtl')->default(0);
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
        Schema::dropIfExists('langs');
    }
}
