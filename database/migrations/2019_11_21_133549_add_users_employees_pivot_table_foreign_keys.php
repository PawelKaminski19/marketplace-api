<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersEmployeesPivotTableForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_employees', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_employees', function (Blueprint $table) {
            //$table->dropForeign('users_employees_user_id_foreign');
            //$table->dropIndex('users_employees_user_id_foreign');

            //$table->dropForeign('users_employees_employee_id_foreign');
            //$table->dropIndex('users_employees_employee_id_foreign');
        });
    }
}
