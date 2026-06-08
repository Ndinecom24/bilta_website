<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactFieldsToTestimoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testimonies', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonies', 'email')) {
                $table->string('email')->nullable()->after('name');
            }

            if (!Schema::hasColumn('testimonies', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testimonies', function (Blueprint $table) {
            if (Schema::hasColumn('testimonies', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('testimonies', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
}
