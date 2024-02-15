<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_interconsultation', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('history_id');
            $table->unsignedInteger('specialty_id');

            $table->timestamps();

            $table->foreign('history_id')->references('id')->on('medical_records');
            $table->foreign('specialty_id')->references('id')->on('specialties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_interconsultation');
    }
};
