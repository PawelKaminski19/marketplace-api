<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientsBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_brands', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->tinyInteger('position')->unsigned()->defalut(0);
            $table->tinyInteger('active')->unsigned()->defalut(1);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients_brands');
    }
}
