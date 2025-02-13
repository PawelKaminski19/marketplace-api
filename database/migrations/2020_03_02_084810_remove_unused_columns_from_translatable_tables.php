<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedColumnsFromTranslatableTables extends Migration
{
    /**
     * Remove translated columns for models using Translatable
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('path');
            $table->dropColumn('slug');
            $table->dropColumn('url');
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
        });

        //Countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        //Currencies table
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        //Genders table
        Schema::table('genders', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        //Products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('description_short');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
        });

        //Websites table
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('subtitle');
            $table->dropColumn('logotitle');
            $table->dropColumn('logosubtitle');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
        });

        //Website_products table
        Schema::table('websites_products', function (Blueprint $table){
            $table->dropColumn('url');
        });

        //Website_products_metas table
        Schema::table('websites_products_metas', function (Blueprint $table){
            $table->dropColumn('description');
            $table->dropColumn('description_short');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('available_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('path', 255);
            $table->string('slug', 128);
            $table->string('url', 128);
            $table->string('title', 128);
            $table->text('description');
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->string('title', 128);
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->string('name',32);
        });

        Schema::table('genders', function (Blueprint $table) {
            $table->string('title');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('url', 128);
            $table->string('name', 150);
            $table->text('description');
            $table->text('description_short');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
        });

        Schema::table('websites', function (Blueprint $table){
            $table->string('title',255)->nullable();
            $table->string('subtitle',255)->nullable();
            $table->string('logotitle',25)->nullable();
            $table->string('logosubtitle',25)->nullable();
            $table->string('meta_title',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('meta_keywords',255)->nullable();
        });

        Schema::table('websites_products', function (Blueprint $table){
            $table->string('url', 128);
        });

        Schema::table('websites_products_metas', function (Blueprint $table){
            $table->text('description');
            $table->text('description_short');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('available_text', 50)->nullable();
        });
    }
}
