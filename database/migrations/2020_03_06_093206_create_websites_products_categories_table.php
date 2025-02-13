<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesProductsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites_products_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_product_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('position')->default(0);

            $table->foreign('website_product_id')
                ->references('id')
                ->on('websites_products')
                ->onDelete('CASCADE');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites_products_categories');
    }
}
