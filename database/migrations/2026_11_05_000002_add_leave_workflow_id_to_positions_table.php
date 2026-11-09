<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaveWorkflowIdToPositionsTable extends Migration
{
    public function up()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_workflow_id')->nullable()->after('department_id');
            $table->foreign('leave_workflow_id')->references('id')->on('approval_workflows')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['leave_workflow_id']);
            $table->dropColumn('leave_workflow_id');
        });
    }
}
