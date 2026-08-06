<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['memo', 'announcement'])->default('announcement');
            $table->longText('content')->nullable();
            $table->date('publish_date');
            $table->date('expiry_date')->nullable();
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
            $table->enum('visibility', ['all', 'department', 'specific'])->default('all');
            $table->json('visible_to')->nullable(); // future: department IDs or user IDs
            $table->unsignedBigInteger('status_id')->default(1);
            $table->boolean('is_archived')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['publish_date', 'status_id']);
            $table->index('is_archived');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};
