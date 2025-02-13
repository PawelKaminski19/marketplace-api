<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesProductsVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites_products_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('websites_product_id');
            $table->unsignedBigInteger('variant_id');

            $table->foreign('websites_product_id')
                ->references('id')
                ->on('websites_products')
                ->onDelete('CASCADE');
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
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
        Schema::dropIfExists('websites_products_variants');
    }
}
