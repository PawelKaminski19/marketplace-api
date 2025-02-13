<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('profile_id')->unsigned();
            $table->bigInteger('lang_id')->unsigned()->default(1);
            $table->string('lastname',128);
            $table->string('firstname',128);
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
                $table->dropForeign('employees_client_id_foreign');
                $table->dropForeign('employees_lang_id_foreign');
        });
        Schema::dropIfExists('employees');
    }
}
