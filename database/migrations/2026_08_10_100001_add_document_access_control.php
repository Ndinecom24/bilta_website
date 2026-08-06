<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add visibility column to document_folders
        Schema::table('document_folders', function (Blueprint $table) {
            $table->string('visibility', 20)->default('everyone')->after('description');
            // 'everyone'   = visible to all users
            // 'department'  = visible only to specified departments
            // 'private'     = personal folder, visible only to creator (can share)
        });

        // Folder-level access control
        Schema::create('document_folder_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('document_folders')->cascadeOnDelete();
            $table->string('target_type', 20); // 'department' or 'user'
            $table->unsignedBigInteger('target_id'); // department_id or user_id
            $table->string('permission', 10)->default('view'); // 'view', 'edit', 'manage'
            $table->foreignId('granted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['folder_id', 'target_type', 'target_id'], 'dfa_folder_target');
            $table->index(['target_type', 'target_id'], 'dfa_target');
        });

        // Individual document sharing (overrides/extends folder access)
        Schema::create('document_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->string('target_type', 20); // 'department' or 'user'
            $table->unsignedBigInteger('target_id');
            $table->string('permission', 10)->default('view');
            $table->foreignId('granted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['document_id', 'target_type', 'target_id'], 'ds_doc_target');
            $table->index(['target_type', 'target_id'], 'ds_target');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_shares');
        Schema::dropIfExists('document_folder_access');

        Schema::table('document_folders', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
