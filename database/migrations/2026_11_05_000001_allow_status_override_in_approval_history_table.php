<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AllowStatusOverrideInApprovalHistoryTable extends Migration
{
    public function up()
    {
        // Admin status overrides are logged with action "overridden" and may happen
        // when the application is no longer sitting at a workflow stage.
        DB::statement("ALTER TABLE `approval_history` MODIFY `action` ENUM('approved','rejected','returned','overridden') NOT NULL");
        DB::statement('ALTER TABLE `approval_history` MODIFY `stage_id` BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::table('approval_history')->where('action', 'overridden')->delete();
        DB::table('approval_history')->whereNull('stage_id')->delete();

        DB::statement("ALTER TABLE `approval_history` MODIFY `action` ENUM('approved','rejected','returned') NOT NULL");
        DB::statement('ALTER TABLE `approval_history` MODIFY `stage_id` BIGINT UNSIGNED NOT NULL');
    }
}
