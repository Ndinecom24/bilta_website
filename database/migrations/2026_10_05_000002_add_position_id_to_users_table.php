<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable()->after('position');
            $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
        });

        if (Schema::hasTable('user_department_responsibilities')) {
            Schema::table('user_department_responsibilities', function (Blueprint $table) {
                $table->unsignedBigInteger('position_id')->nullable()->after('position');
                $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('user_department_responsibilities')) {
            Schema::table('user_department_responsibilities', function (Blueprint $table) {
                $table->dropForeign(['position_id']);
                $table->dropColumn('position_id');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });
    }
}
