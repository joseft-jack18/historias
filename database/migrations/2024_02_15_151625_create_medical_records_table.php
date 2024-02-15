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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('person_id');

            $table->string('quantity')->nullable();
            $table->string('time')->nullable();
            $table->string('reason_consultation');
            $table->string('main_symptoms');
            $table->integer('thirst')->nullable();
            $table->integer('appetite')->nullable();
            $table->integer('dream')->nullable();
            $table->integer('urinary_rhythm')->nullable();
            $table->integer('evacuation_rhythm')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('breathing_frequency')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('temperature')->nullable();
            $table->string('weight')->nullable();
            $table->string('sice')->nullable();
            $table->string('imc')->nullable();
            $table->text('general_exam')->nullable();
            $table->text('preferential_exam')->nullable();
            $table->text('hygienic_measures')->nullable();
            $table->text('observations')->nullable();
            $table->date('next_attention')->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};
