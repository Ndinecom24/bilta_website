<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchApproversTable extends Migration
{
    /**
     * Which people act in which role for a branch's leave applications.
     * e.g. Tembo = Supervisor for branches 1, 2 and 3; Mary = HR for branch 1.
     */
    public function up()
    {
        Schema::create('branch_approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['branch_id', 'role_id', 'user_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('branch_approvers');
    }
}
