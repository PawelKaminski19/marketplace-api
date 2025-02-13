<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateI18nTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('langs', 'i18n_languages');

        Schema::table('i18n_languages', function (Blueprint $table) {
            $table->renameColumn('is_code', 'locale');
        });

        Schema::create('i18n_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('i18n_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('i18n_modules')->onDelete('cascade')->onUpdate('cascade');
            $table->string('key');
            $table->tinyInteger('type')->default(1)->comment('Field type');
            $table->timestamps();

            $table->index(['key']);
            $table->index(['key', 'module_id']);
        });

        Schema::create('i18n_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('i18n_languages')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('key_id');
            $table->foreign('key_id')->references('id')->on('i18n_keys')->onDelete('cascade')->onUpdate('cascade');
            $table->text('translation');
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
        Schema::dropIfExists('i18n_translations');
        Schema::dropIfExists('i18n_keys');
        Schema::dropIfExists('i18n_modules');

        Schema::table('i18n_languages', function (Blueprint $table) {
            $table->renameColumn('locale', 'is_code');
        });

        Schema::rename('i18n_languages', 'langs');
    }
}
