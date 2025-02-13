<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsbnUpcColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unique('ean13');
            $table->string('isbn', 32)->nullable()->unique()->after('ean13');
            $table->string('upc', 13)->nullable()->unique()->after('isbn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_ean13_unique');
            $table->dropColumn('isbn');
            $table->dropColumn('upc');
        });
    }
}
