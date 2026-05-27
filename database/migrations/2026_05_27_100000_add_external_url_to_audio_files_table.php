<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('audio_files', function (Blueprint $table) {
            if (!Schema::hasColumn('audio_files', 'external_url')) {
                $table->string('external_url')->nullable()->after('file_url');
            }
        });
    }

    public function down()
    {
        Schema::table('audio_files', function (Blueprint $table) {
            $table->dropColumn('external_url');
        });
    }
};
