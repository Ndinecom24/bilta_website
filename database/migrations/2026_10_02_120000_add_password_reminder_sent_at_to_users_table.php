<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordReminderSentAtToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'password_reminder_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('password_reminder_sent_at')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'password_reminder_sent_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('password_reminder_sent_at');
            });
        }
    }
}