<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('token')->unsigned();
            $table->string('hash')->unique();
            $table->string('type', 20);
            $table->string('model', 256)->nullable()->default(null);
            $table->integer('model_id')->unsigned()->nullable()->default(null);
            $table->string('method', 32);
            $table->boolean('used')->nullable()->default(null);
            $table->timestamp('used_date')->nullable()->default(null);
            $table->smallInteger('expiration_minutes')->unsigned()->nullable()->default(null);
            $table->timestamp('expiration_date')->default(Carbon::now()->addHour());
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('tokens');
    }
}
