<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersAffiliatesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_affiliates', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->primary(['user_id','affiliate_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_affiliates');
    }
}
