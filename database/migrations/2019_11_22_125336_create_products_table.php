<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('url', 128);
            $table->string('name', 150);
            $table->text('description');
            $table->text('description_short');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('ean13', 13)->nullable();
            $table->string('reference', 32)->nullable();
            $table->string('reference_brand', 32)->nullable();
            $table->decimal('price', 20, 6)->default(0.000000);
            $table->boolean('show_price')->default(1);
            $table->decimal('width', 20, 6)->default(0.000000);
            $table->decimal('height', 20, 6)->default(0.000000);
            $table->decimal('depth', 20, 6)->default(0.000000);
            $table->decimal('weight', 20, 6)->default(0.000000);
            $table->string('available_text', 50)->nullable();
            $table->unsignedTinyInteger('available_days')->nullable();
            $table->timestamp('available_date')->nullable();
            $table->enum('redirect_type', ['', '404', '301', '302']);
            $table->unsignedBigInteger('redirect_product_id')->nullable();
            $table->boolean('active')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
