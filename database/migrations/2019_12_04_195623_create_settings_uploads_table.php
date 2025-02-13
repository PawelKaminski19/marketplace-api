<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('website_id')->unsigned()->nullable();
            $table->bigInteger('domain_id')->unsigned()->nullable();
            $table->tinyInteger('core')->unsigned()->default(0);
            $table->string('model', 50);
            $table->string('type', 50);
            $table->string('sizes', 50);
            $table->smallInteger('max_allowed_files')->unsigned();
            $table->string('jpg_quality', 5);
            $table->string('png_quality', 5);
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_uploads');
    }
}
