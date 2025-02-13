<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteBrandIdFromWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign('websites_brand_id_foreign');
            $table->dropColumn('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->bigInteger('brand_id')->unsigned()->nullable(true)->default(null);
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }
}
