<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('weekly_prayer_points', function (Blueprint $table) {
            if (!Schema::hasColumn('weekly_prayer_points', 'year')) {
                $table->unsignedSmallInteger('year')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('weekly_prayer_points', 'month')) {
                $table->unsignedTinyInteger('month')->nullable()->after('year');
            }
            if (!Schema::hasColumn('weekly_prayer_points', 'week')) {
                $table->unsignedTinyInteger('week')->nullable()->after('month');
            }
            if (!Schema::hasColumn('weekly_prayer_points', 'day')) {
                $table->unsignedTinyInteger('day')->nullable()->after('week');
            }
        });
    }

    public function down()
    {
        Schema::table('weekly_prayer_points', function (Blueprint $table) {
            $table->dropColumn(['year', 'month', 'week', 'day']);
        });
    }
};
