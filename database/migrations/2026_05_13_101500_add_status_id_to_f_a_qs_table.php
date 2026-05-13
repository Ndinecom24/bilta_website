<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('f_a_qs', 'status_id')) {
            Schema::table('f_a_qs', function (Blueprint $table) {
                $table->unsignedBigInteger('status_id')->nullable()->after('answer');
            });
        }

        DB::table('f_a_qs')->whereNull('status_id')->update(['status_id' => 1]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('f_a_qs', 'status_id')) {
            Schema::table('f_a_qs', function (Blueprint $table) {
                $table->dropColumn('status_id');
            });
        }
    }
};
