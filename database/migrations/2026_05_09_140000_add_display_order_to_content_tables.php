<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayOrderToContentTables extends Migration
{
    public function up()
    {
        if (Schema::hasTable('our_teams') && !Schema::hasColumn('our_teams', 'display_order')) {
            Schema::table('our_teams', function (Blueprint $table) {
                $table->unsignedInteger('display_order')->default(0)->after('position');
            });
        }

        if (Schema::hasTable('projects') && !Schema::hasColumn('projects', 'display_order')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedInteger('display_order')->default(0)->after('category_id');
            });
        }

        if (Schema::hasTable('news_item') && !Schema::hasColumn('news_item', 'display_order')) {
            Schema::table('news_item', function (Blueprint $table) {
                $table->unsignedInteger('display_order')->default(0)->after('category_id');
            });
        }

        if (Schema::hasTable('sponsors') && !Schema::hasColumn('sponsors', 'display_order')) {
            Schema::table('sponsors', function (Blueprint $table) {
                $table->unsignedInteger('display_order')->default(0)->after('description');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('our_teams') && Schema::hasColumn('our_teams', 'display_order')) {
            Schema::table('our_teams', function (Blueprint $table) {
                $table->dropColumn('display_order');
            });
        }

        if (Schema::hasTable('projects') && Schema::hasColumn('projects', 'display_order')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('display_order');
            });
        }

        if (Schema::hasTable('news_item') && Schema::hasColumn('news_item', 'display_order')) {
            Schema::table('news_item', function (Blueprint $table) {
                $table->dropColumn('display_order');
            });
        }

        if (Schema::hasTable('sponsors') && Schema::hasColumn('sponsors', 'display_order')) {
            Schema::table('sponsors', function (Blueprint $table) {
                $table->dropColumn('display_order');
            });
        }
    }
}
