<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesI18nTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_i18n', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale', 6);
            $table->string('model');
            $table->integer('foreign_key');
            $table->string('field');
            $table->text('content');
            $table->timestamps();

            $table->unique(['locale', 'model', 'foreign_key', 'field'], 'I18N_LOCALE_FIELD');
            $table->index(['model', 'foreign_key', 'field'], 'I18N_FIELD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_i18n');
    }
}
