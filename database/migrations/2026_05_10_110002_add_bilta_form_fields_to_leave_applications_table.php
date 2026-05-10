<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiltaFormFieldsToLeaveApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->date('resume_date')->nullable()->after('end_date');
            $table->string('other_leave_type_text')->nullable()->after('leave_type_id');
            // Acting arrangement
            $table->string('acting_name')->nullable()->after('document_path');
            $table->string('acting_cell')->nullable()->after('acting_name');
            $table->string('acting_position')->nullable()->after('acting_cell');
        });
    }

    public function down()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->dropColumn([
                'resume_date', 'other_leave_type_text',
                'acting_name', 'acting_cell', 'acting_position',
            ]);
        });
    }
}
