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
        Schema::create('cat_identity_document_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('cat_identity_document_types')->insert([
            ['id' => '0', 'active' => true,  'description' => 'Doc.trib.no.dom.sin.ruc'],
            ['id' => '1', 'active' => true,  'description' => 'DNI'],
            ['id' => '4', 'active' => true,  'description' => 'CE'],
            ['id' => '6', 'active' => true,  'description' => 'RUC'],
            ['id' => '7', 'active' => true,  'description' => 'Pasaporte'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_identity_document_types');
    }
};
