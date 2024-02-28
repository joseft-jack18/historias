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
        Schema::create('medical_work_plans', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('history_id');
            $table->unsignedInteger('procedure_id');
            $table->string('type');

            $table->timestamps();

            $table->foreign('history_id')->references('id')->on('medical_records');
            $table->foreign('procedure_id')->references('id')->on('procedures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_work_plans');
    }
};
