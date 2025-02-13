<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('website_id')->unsigned()->nullable();
            $table->tinyInteger('https')->unsigned()->default(0);
            $table->string('url', 256)->unique();
            $table->string('analytics', 15)->nullable();
            $table->tinyInteger('main')->nullable();
            $table->tinyInteger('live')->unsigned()->default(0);
            $table->tinyInteger('active')->unsigned()->nullable();
            $table->timestamps();

        });


        Schema::table('domains', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('set null');
        });
        Schema::table('guests', function (Blueprint $table) {

            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign('guests_domain_id_foreign');
            $table->dropIndex('guests_domain_id_foreign');
        });

        Schema::table('domains', function (Blueprint $table) {
            $table->dropForeign('domains_client_id_foreign');
            $table->dropIndex('domains_client_id_foreign');
            $table->dropForeign('domains_website_id_foreign');
            $table->dropIndex('domains_website_id_foreign');
        });
        Schema::dropIfExists('domains');
    }
}
