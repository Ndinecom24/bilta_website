<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Annual Leave, Sick Leave, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('default_days')->default(0);  // Default annual allowance
            $table->boolean('requires_document')->default(false); // e.g. medical cert for sick leave
            $table->boolean('is_paid')->default(true);
            $table->boolean('carry_over')->default(false);        // Can unused days roll over?
            $table->integer('max_carry_over_days')->default(0);   // Max days to carry over
            $table->unsignedBigInteger('status_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_types');
    }
}
