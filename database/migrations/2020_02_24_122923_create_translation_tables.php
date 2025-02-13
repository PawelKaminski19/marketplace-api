<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationTables extends Migration
{
    /*
    - categories [path(A), slug(A), url(A), title, description, meta_title, meta_description, meta_keywords]
    - countries [title],
    - currencies [name],
    - genders [title],
    - products [url(A), name, description, description_short, meta_title, meta_description, meta_keywords]
    - websites [title, subtitle, logotitle, logosubtitle, meta_title, meta_description, meta_keywords]
    - websites_products [url(A)]
    - websites_products_metas [description, description_short, meta_title, meta_description, meta_keywords, available_text]
    - zones [name]
    */

    const SUFFIX = '_translations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('locale')->index();

            $table->string('path')->nullable()->default(null);
            $table->string('slug');
            $table->string('url');
            $table->string('title');
            $table->text('description');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::dropIfExists('categories_i18n');

        Schema::create('country'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');
            $table->string('locale')->index();

            $table->string('title');

            $table->unique(['country_id', 'locale']);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('currency'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id');
            $table->string('locale')->index();

            $table->string('name');

            $table->unique(['currency_id', 'locale']);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });

        Schema::create('gender'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gender_id');
            $table->string('locale')->index();

            $table->string('title');

            $table->unique(['gender_id', 'locale']);
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
        });

        Schema::create('product'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('locale')->index();

            $table->string('url');
            $table->string('name');
            $table->text('description');
            $table->text('description_short');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('website'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_id');
            $table->string('locale')->index();

            $table->string('title');
            $table->string('subtitle');
            $table->string('logotitle')->nullable();
            $table->string('logosubtitle')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->unique(['website_id', 'locale']);
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
        });

        Schema::create('websites_product'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('websites_product_id');
            $table->string('locale')->index();

            $table->string('url');

            $table->unique(['websites_product_id', 'locale']);
            $table->foreign('websites_product_id')->references('id')->on('websites_products')->onDelete('cascade');
        });

        Schema::create('websites_products_meta'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('websites_products_meta_id');
            $table->string('locale')->index();

            $table->string('name');
            $table->text('description');
            $table->text('description_short');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('available_text');

            $table->unique(['websites_products_meta_id', 'locale'], 'wpm_unique');
            $table->foreign('websites_products_meta_id', 'wpm_id_foreign')->references('id')->on('websites_products_metas')->onDelete('cascade');
        });

        Schema::create('zone'.self::SUFFIX, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('zone_id');
            $table->string('locale')->index();

            $table->string('name');

            $table->unique(['zone_id', 'locale']);
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category'.self::SUFFIX);
        Schema::dropIfExists('country'.self::SUFFIX);
        Schema::dropIfExists('currency'.self::SUFFIX);
        Schema::dropIfExists('gender'.self::SUFFIX);
        Schema::dropIfExists('product'.self::SUFFIX);
        Schema::dropIfExists('website'.self::SUFFIX);
        Schema::dropIfExists('websites_product'.self::SUFFIX);
        Schema::dropIfExists('websites_products_meta'.self::SUFFIX);
        Schema::dropIfExists('zone'.self::SUFFIX);
    }
}
