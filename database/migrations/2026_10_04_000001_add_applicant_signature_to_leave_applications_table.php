<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicantSignatureToLeaveApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->string('applicant_signature_path')->nullable()->after('document_path');
            $table->timestamp('applicant_signed_at')->nullable()->after('applicant_signature_path');
        });
    }

    public function down()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->dropColumn(['applicant_signature_path', 'applicant_signed_at']);
        });
    }
}
