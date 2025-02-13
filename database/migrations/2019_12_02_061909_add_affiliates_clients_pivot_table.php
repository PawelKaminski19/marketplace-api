<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliatesClientsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates_clients', function (Blueprint $table) {
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->primary(['affiliate_id','client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates_clients');
    }
}
