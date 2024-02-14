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
        Schema::create('specialties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });

        DB::table('specialties')->insert([
            ['id' => 1,'description' => 'ECOGRAFIA'],
            ['id' => 2,'description' => 'LABORATORIO'],
            ['id' => 3,'description' => 'RADIOLOGIA'],
            ['id' => 4,'description' => 'TOMOGRAFIA'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialties');
    }
};
