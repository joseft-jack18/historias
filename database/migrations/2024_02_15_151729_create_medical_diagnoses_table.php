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
        Schema::create('medical_diagnoses', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('history_id');
            $table->unsignedInteger('diagnosis_id');

            $table->timestamps();

            $table->foreign('history_id')->references('id')->on('medical_records');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_diagnoses');
    }
};
