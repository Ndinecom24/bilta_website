<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignaturePathToApprovalHistoryTable extends Migration
{
    public function up()
    {
        Schema::table('approval_history', function (Blueprint $table) {
            $table->string('signature_path')->nullable()->after('comment');
        });
    }

    public function down()
    {
        Schema::table('approval_history', function (Blueprint $table) {
            $table->dropColumn('signature_path');
        });
    }
}
