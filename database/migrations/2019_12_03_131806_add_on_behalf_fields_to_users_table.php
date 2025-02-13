<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnBehalfFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('onbehalf_id')->unsigned()->nullable()->after('softwareowner_id');
            $table->string('onbehalf_type')->nullable()->after('userable_type');
            $table->timestamp('onbehalf_time')->nullable()->after('onbehalf_type');
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
            Schema::dropIfExists('onbehalf_id');
            Schema::dropIfExists('onbehalf_type');
        });
    }
}
