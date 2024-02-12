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
        Schema::create('departments', function (Blueprint $table) {
            $table->char('id', 2)->index();
            $table->string('description');
            $table->boolean('active')->default(true);
        });

        DB::table('departments')->insert([
            ['id' => '01', 'description' => 'AMAZONAS'],
            ['id' => '02', 'description' => 'ÁNCASH'],
            ['id' => '03', 'description' => 'APURIMAC'],
            ['id' => '04', 'description' => 'AREQUIPA'],
            ['id' => '05', 'description' => 'AYACUCHO'],
            ['id' => '06', 'description' => 'CAJAMARCA'],
            ['id' => '07', 'description' => 'CALLAO'],
            ['id' => '08', 'description' => 'CUSCO'],
            ['id' => '09', 'description' => 'HUANCAVELICA'],
            ['id' => '10', 'description' => 'HUÁNUCO'],
            ['id' => '11', 'description' => 'ICA'],
            ['id' => '12', 'description' => 'JUNÍN'],
            ['id' => '13', 'description' => 'LA LIBERTAD'],
            ['id' => '14', 'description' => 'LAMBAYEQUE'],
            ['id' => '15', 'description' => 'LIMA'],
            ['id' => '16', 'description' => 'LORETO'],
            ['id' => '17', 'description' => 'MADRE DE DIOS'],
            ['id' => '18', 'description' => 'MOQUEGUA'],
            ['id' => '19', 'description' => 'PASCO'],
            ['id' => '20', 'description' => 'PIURA'],
            ['id' => '21', 'description' => 'PUNO'],
            ['id' => '22', 'description' => 'SAN MARTIN'],
            ['id' => '23', 'description' => 'TACNA'],
            ['id' => '24', 'description' => 'TUMBES'],
            ['id' => '25', 'description' => 'UCAYALI'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
