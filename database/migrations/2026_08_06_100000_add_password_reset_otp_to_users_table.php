<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordResetOtpToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'password_change')) {
                $table->integer('password_change')->default(0)->after('password');
            }
            $table->string('password_reset_otp', 10)->nullable();
            $table->timestamp('password_reset_otp_expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['password_reset_otp', 'password_reset_otp_expires_at']);
        });
    }
}
