<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('website_id')->unsigned();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->bigInteger('lang_id')->unsigned()->default(1);
            $table->bigInteger('group_id')->unsigned()->nullable();


            $table->string('company',128)->nullable();
            $table->string('firstname',128)->nullable();
            $table->string('lastname',128)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('digest_hash',128)->nullable();
            $table->dateTime('accepted_terms')->nullable();
            $table->dateTime('newsletter_sub')->nullable();
            $table->dateTime('newsletter_optin')->nullable();
            $table->dateTime('newsletter_unsub')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('is_guest')->unsigned()->nullable();
            $table->tinyInteger('active')->unsigned();
            $table->dateTime('deleted')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_client_id_foreign');
            $table->dropForeign('customers_website_id_foreign');
            $table->dropForeign('customers_gender_id_foreign');
            $table->dropForeign('customers_lang_id_foreign');
        });
        Schema::dropIfExists('customers');
    }
}
