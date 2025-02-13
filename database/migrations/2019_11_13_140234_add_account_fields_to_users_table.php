<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->nullable()->after('id');
            $table->bigInteger('softwareowner_id')->unsigned()->nullable()->after('client_id');

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('softwareowner_id')->references('id')->on('softwareowners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_softwareowner_id_foreign');
            $table->dropForeign('users_client_id_foreign');
            $table->dropColumn('softwareowner_id');
            $table->dropColumn('client_id');
        });
    }
}
