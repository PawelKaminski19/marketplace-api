<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->index()->nullable();
            $table->unsignedBigInteger('website_id')->index()->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('CASCADE');
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('CASCADE');
        });

        Schema::create('variant_group_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variant_group_id');
            $table->string('locale')->index();

            $table->string('name');
            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->unique(['variant_group_id', 'locale']);
            $table->foreign('variant_group_id')
                ->references('id')
                ->on('variant_groups')
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
        Schema::dropIfExists('variant_group_translations');
        Schema::dropIfExists('variant_groups');
    }
}
