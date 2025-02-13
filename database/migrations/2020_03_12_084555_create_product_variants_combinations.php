<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsCombinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants_combinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            //TODO: change nullable after development.
            $table->unsignedBigInteger('client_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('reference', 32)->nullable();
            $table->string('reference_brand', 32)->nullable();
            $table->string('ean13', 13)->nullable();
            $table->decimal('price', 20, 6)->nullable()->default(0.000000);
            $table->decimal('weight', 20, 6)->default(0.000000);
            $table->unsignedInteger('quantity')->default(0);
            $table->boolean('standard')->default(false);
            $table->string('available_text', 50)->nullable();
            $table->integer('available_days')->nullable();
            $table->timestamp('available_date')->nullable();
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
        Schema::dropIfExists('product_variants_combinations');
    }
}
