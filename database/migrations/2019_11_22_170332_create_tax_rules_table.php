<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('tax_rule_group_id');
            $table->unsignedBigInteger('country_id');
            $table->string('description', 100);
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->unique(['tax_rule_group_id', 'country_id', 'tax_id'], 'tax_rule_group_id_2');

            $table->foreign('tax_rule_group_id')->references('id')->on('tax_rule_groups')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_rules');
    }
}
