<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalWorkflowStagesTable extends Migration
{
    public function up()
    {
        Schema::create('approval_workflow_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('approval_workflows')->cascadeOnDelete();
            $table->string('name');                          // e.g. "Line Manager Approval", "HR Review"
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();   // which role can approve
            $table->unsignedSmallInteger('stage_order');     // 1, 2, 3 …
            $table->boolean('is_start')->default(false);     // first stage
            $table->boolean('is_end')->default(false);       // final stage — approval here = fully approved
            $table->timestamps();

            $table->unique(['workflow_id', 'stage_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('approval_workflow_stages');
    }
}
