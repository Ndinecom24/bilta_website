<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClicksTableUrlReferrerToText extends Migration
{
    public function up()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->text('url')->change();
            $table->text('referrer')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->string('url')->change();
            $table->string('referrer')->nullable()->change();
        });
    }
}
