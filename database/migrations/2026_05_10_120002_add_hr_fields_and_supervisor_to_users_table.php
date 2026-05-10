<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrFieldsAndSupervisorToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Supervisor (self-referencing)
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('status_id');
            $table->foreign('supervisor_id')->references('id')->on('users')->nullOnDelete();

            // Department FK (replaces text 'department' column)
            $table->unsignedBigInteger('department_id')->nullable()->after('supervisor_id');
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();

            // Additional HR fields
            $table->string('employee_id', 50)->nullable()->after('man_number');
            $table->date('date_of_birth')->nullable()->after('employee_id');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->date('date_joined')->nullable()->after('gender');
            $table->enum('contract_type', ['permanent', 'contract', 'part-time', 'intern', 'volunteer'])->nullable()->after('date_joined');
            $table->text('address')->nullable()->after('contract_type');
            $table->string('emergency_contact_name')->nullable()->after('address');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'supervisor_id', 'department_id', 'employee_id',
                'date_of_birth', 'gender', 'date_joined', 'contract_type',
                'address', 'emergency_contact_name', 'emergency_contact_phone',
            ]);
        });
    }
}
