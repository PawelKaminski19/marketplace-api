<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSystemownersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemowners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lang_id')->unsigned()->default(1);
            $table->string('lastname',128);
            $table->string('firstname',128);
            $table->tinyInteger('active')->unsigned()->default(1);
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
        Schema::dropIfExists('systemowners');
    }
}
