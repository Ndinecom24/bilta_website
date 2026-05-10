<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkflowColumnsToLeaveApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->foreignId('workflow_id')->nullable()->after('status')->constrained('approval_workflows')->nullOnDelete();
            $table->foreignId('current_stage_id')->nullable()->after('workflow_id')->constrained('approval_workflow_stages')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->dropForeign(['workflow_id']);
            $table->dropForeign(['current_stage_id']);
            $table->dropColumn(['workflow_id', 'current_stage_id']);
        });
    }
}
