<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->bigInteger('website_type_id')->unsigned();

            $table->string('url',64)->nullable();
            $table->string('slug',64)->nullable();
            $table->string('title',255)->nullable();
            $table->string('subtitle',255)->nullable();
            $table->string('logotitle',25)->nullable();
            $table->string('logosubtitle',25)->nullable();
            $table->string('meta_title',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('meta_keywords',255)->nullable();
            $table->string('layout',32)->nullable();

            $table->tinyInteger('active')->unsigned()->default("1");
            $table->tinyInteger('deleted')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('website_translations', function (Blueprint $table) {
            //$table->dropForeign(['website_id']);
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign('websites_client_id_foreign');
            $table->dropForeign('websites_brand_id_foreign');
        });
        Schema::dropIfExists('websites');
    }
}
