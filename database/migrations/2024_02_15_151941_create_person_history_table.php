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
        Schema::create('person_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->text('personal_history');
            $table->text('allergies_history');
            $table->text('family_history');
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
        Schema::dropIfExists('person_history');
    }
};
