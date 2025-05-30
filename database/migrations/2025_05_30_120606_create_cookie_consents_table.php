<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookieConsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
    $table->string('ip_address')->nullable();
    $table->boolean('analytics')->default(false);
    $table->boolean('marketing')->default(false);
    $table->timestamp('consent_given_at');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cookie_consents');
    }
}
