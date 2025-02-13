<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('product_variant_combination_id');
                $table->unsignedBigInteger('variant_id');

                $table->foreign('product_variant_combination_id')
                    ->references('id')
                    ->on('product_variants_combinations')
                    ->onDelete('CASCADE');
                $table->foreign('variant_id')
                    ->references('id')
                    ->on('variants')
                    ->onDelete('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
