<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersTable extends Migration
{
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->longText('content');
            $table->date('publish_date')->nullable();
            $table->unsignedBigInteger('status_id')->default(3); // pending
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('emails_sent')->default(false);
            $table->timestamp('emails_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletters');
    }
}
