<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('website_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->tinyInteger('depth')->unsigned()->default(0);
            $table->tinyInteger('root')->unsigned()->default(0);
            $table->integer('position')->unsigned()->default(0);

            $table->string('path',255)->nullable();
            $table->string('slug',128);
            $table->string('url',128);
            $table->string('title',128);
            $table->text('description');
            $table->string('meta_title',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('meta_keywords',255)->nullable();

            $table->tinyInteger('active')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories_products', function (Blueprint $table) {
            // $table->dropForeign(['category_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['website_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('categories');
    }
}
