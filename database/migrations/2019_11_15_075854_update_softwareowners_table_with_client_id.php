<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoftwareownersTableWithClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('softwareowners', function (Blueprint $table) {
            $table->dropForeign('softwareowners_gender_id_foreign');
            $table->dropColumn('lastname');
            $table->dropColumn('firstname');
            $table->dropColumn('active');
            $table->dropColumn('terms_accepted');
            $table->dropColumn('terms_accepted_time');
            $table->dropColumn('gender_id');

            $table->bigInteger('client_id')->unsigned()->nullable()->after('id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('softwareowners', function (Blueprint $table) {

            $table->string('lastname',128);
            $table->string('firstname',128);
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->tinyInteger('active')->unsigned()->default(1);

            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            //$table->dropForeign('softwareowners_client_id_foreign');
        });
    }
}
