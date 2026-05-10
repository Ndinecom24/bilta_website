<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('position')->nullable()->after('phone');
            $table->string('department')->nullable()->after('position');
            $table->string('nrc')->nullable()->after('department');
            $table->string('man_number')->nullable()->after('nrc');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['position', 'department', 'nrc', 'man_number']);
        });
    }
}
