<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lang_id')->unsigned()->default(1);
            $table->string('lastname',128);
            $table->string('firstname',128);
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliates', function (Blueprint $table) {
                $table->dropForeign('affiliates_lang_id_foreign');
        });
        Schema::dropIfExists('affiliates');
    }
}
