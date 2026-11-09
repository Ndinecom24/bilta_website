<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTables extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 30)->unique();
            $table->string('subject', 200);
            $table->longText('description');
            $table->string('status', 30)->default('new')->index();

            $table->foreignId('category_id')->constrained('ticket_categories')->restrictOnDelete();
            $table->foreignId('system_id')->nullable()->constrained('ticket_systems')->nullOnDelete();
            $table->foreignId('priority_id')->constrained('ticket_priorities')->restrictOnDelete();

            // Keep tickets (and the audit trail) even if a user account is removed
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            // Developer task tracking
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->date('due_date')->nullable()->index();
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->unsignedSmallInteger('reopen_count')->default(0);

            $table->text('technical_findings')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->text('outstanding_requirements')->nullable();

            $table->timestamps();

            $table->index('assigned_to');
            $table->index('submitted_by');
            $table->index('created_at');
        });

        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('body');
            $table->boolean('is_internal')->default(false);               // developer-only note
            $table->boolean('is_clarification_request')->default(false);
            $table->timestamps();

            $table->index(['ticket_id', 'created_at']);
        });

        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('ticket_comments')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('original_name');
            $table->string('path');                                       // random name on the private disk
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('checksum', 64)->nullable();
            $table->timestamps();
        });

        // Append-only audit trail
        Schema::create('ticket_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('event', 50);
            $table->string('from_value')->nullable();
            $table->string('to_value')->nullable();
            $table->text('note')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['ticket_id', 'created_at']);
        });

        Schema::create('ticket_work_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('developer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('work_date');
            $table->decimal('hours', 6, 2);                               // actual hours worked
            $table->string('work_type', 30)->default('development');
            $table->text('description');

            // Billing is kept separate from actual effort and set only on approval
            $table->boolean('is_billable')->default(true);
            $table->decimal('billable_hours', 6, 2)->nullable();
            $table->decimal('rate_applied', 10, 2)->nullable();           // snapshot of the rate at approval
            $table->string('currency', 3)->nullable();
            $table->string('billing_status', 20)->default('unreviewed');  // unreviewed | approved | non_billable
            $table->foreignId('billing_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('billing_approved_at')->nullable();

            $table->timestamps();

            $table->index(['ticket_id', 'work_date']);
            $table->index('developer_id');
        });

        Schema::create('ticket_billing_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('hourly_rate', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->foreignId('developer_id')->nullable()->constrained('users')->nullOnDelete(); // null = default rate
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_billing_rates');
        Schema::dropIfExists('ticket_work_logs');
        Schema::dropIfExists('ticket_events');
        Schema::dropIfExists('ticket_attachments');
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('tickets');
    }
}
