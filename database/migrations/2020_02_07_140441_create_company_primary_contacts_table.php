<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPrimaryContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_primary_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->bigInteger('citizen_country_id')->unsigned()->nullable();
            $table->bigInteger('birth_country_id')->unsigned()->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyInteger('identity_proof_type')->unsigned()->nullable();
            $table->string('identity_proof_nr',32)->nullable();
            $table->date('identity_proof_expiry')->nullable();
            $table->tinyInteger('active')->unsigned()->default("1");
            $table->timestamps();
        });
        Schema::table('company_primary_contacts', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('citizen_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('birth_country_id')->references('id')->on('countries')->onDelete('cascade');
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_primary_contacts', function (Blueprint $table) {
            $table->dropForeign('company_primary_contacts_company_id_foreign');
            $table->dropForeign('company_primary_contacts_address_id_foreign');
            $table->dropForeign('company_primary_contacts_citizen_country_id_foreign');
            $table->dropForeign('company_primary_contacts_birth_country_id_foreign');

            $table->dropIndex('company_primary_contacts_company_id_foreign');
            $table->dropIndex('company_primary_contacts_address_id_foreign');
            $table->dropIndex('company_primary_contacts_citizen_country_id_foreign');
            $table->dropIndex('company_primary_contacts_birth_country_id_foreign');
        });
        Schema::dropIfExists('company_primary_contacts');
    }
}
