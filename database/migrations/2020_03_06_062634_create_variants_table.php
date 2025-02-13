<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variant_group_id')->index();
            $table->integer('position')->default(0);
            $table->boolean('optional')->nullable();
            $table->integer('delivery_days')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('variant_group_id')
                ->references('id')
                ->on('variant_groups')
                ->onDelete('CASCADE');
        });

        Schema::create('variant_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variant_id');
            $table->string('locale');

            $table->string('title');
            $table->string('subtitle');

            $table->unique(['variant_id', 'locale']);
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
        Schema::dropIfExists('variant_translations');
        Schema::dropIfExists('variants');
    }
}
