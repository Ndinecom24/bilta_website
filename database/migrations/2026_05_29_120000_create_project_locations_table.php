<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('project_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name'); // Location name e.g. "Lusaka Office", "Chipata Field Site"
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_locations');
    }
}
