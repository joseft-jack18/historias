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
        Schema::create('medical_treatments', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('history_id');
            $table->string('medicine');
            $table->string('shape');
            $table->string('dose');
            $table->string('quantity');
            $table->text('indications');

            $table->timestamps();

            $table->foreign('history_id')->references('id')->on('medical_records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_treatments');
    }
};
