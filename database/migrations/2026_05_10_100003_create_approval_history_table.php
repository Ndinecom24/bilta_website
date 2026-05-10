<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('approval_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_application_id')->constrained('leave_applications')->cascadeOnDelete();
            $table->foreignId('stage_id')->constrained('approval_workflow_stages')->cascadeOnDelete();
            $table->foreignId('acted_by')->constrained('users')->cascadeOnDelete();  // who took action
            $table->enum('action', ['approved', 'rejected', 'returned']);             // action taken
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approval_history');
    }
}
