<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('website_id')->unsigned()->nullable();
            $table->biginteger('user_id')->unsigned()->nullable();
            $table->string('model', 100)->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->string('type', 15)->nullable();
            $table->string('subtype', 15)->nullable();
            $table->string('title', 100)->nullable();


            $table->string('name');
            $table->string('subfolder', 50)->nullable();
            $table->string('mimetype', 50)->nullable();
            $table->string('extension', 10);
            $table->string('size', 12);
            $table->json('dimensions');
            $table->string('hash')->nullable();
            $table->string('md5');
            $table->boolean('complete')->default(0);
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
        Schema::dropIfExists('uploads');
    }
}
