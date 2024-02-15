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
            ['id' => 1, 'description' => 'ECOGRAFIA'],
            ['id' => 2, 'description' => 'LABORATORIO'],
            ['id' => 3, 'description' => 'RADIOLOGIA'],
            ['id' => 4, 'description' => 'TOMOGRAFIA'],
            ['id' => 5, 'description' => 'CARDIOLOGIA'],
            ['id' => 6, 'description' => 'CARDIOLOGIA PEDIATRICA'],
            ['id' => 7, 'description' => 'CIRUGIA DE CABEZA Y CUELLO'],
            ['id' => 8, 'description' => 'CIRUGIA DE TÓRAX Y CARDIOVASCULAR'],
            ['id' => 9, 'description' => 'CIRUGIA GENERAL'],
            ['id' => 10, 'description' => 'CIRUGIA ONCOLOGICA'],
            ['id' => 11, 'description' => 'CIRUGIA PEDIATRICA'],
            ['id' => 12, 'description' => 'CIRUGIA PLASTICA Y REPARADORA'],
            ['id' => 13, 'description' => 'COSMIATRIA'],
            ['id' => 14, 'description' => 'DENSITROMETRIA OSEA'],
            ['id' => 15, 'description' => 'DERMATOLOGIA'],
            ['id' => 16, 'description' => 'DERMATOLOGIA PEDIATRICA'],
            ['id' => 17, 'description' => 'ENDOCRINOLOGIA'],
            ['id' => 18, 'description' => 'GASTROENTEROLOGIA'],
            ['id' => 19, 'description' => 'GASTROENTEROLOGIA PEDIATRICA'],
            ['id' => 20, 'description' => 'GERIATRIA'],
            ['id' => 21, 'description' => 'GINECOLOGIA ONCOLOGICA'],
            ['id' => 22, 'description' => 'GINECOLOGIA Y OBSTETRICA'],
            ['id' => 23, 'description' => 'HEMATOLOGIA'],
            ['id' => 24, 'description' => 'INFECTOLOGIA'],
            ['id' => 25, 'description' => 'INMUNOLOGIA Y ALERGIA'],
            ['id' => 26, 'description' => 'MEDICINA DE ENFERMEDADES INFECCIOSAS Y TROPICALES'],
            ['id' => 27, 'description' => 'MEDICINA FAMILIAR Y COMUNITARIA'],
            ['id' => 28, 'description' => 'MEDICINA FISICA Y REHABILITACION'],
            ['id' => 29, 'description' => 'MEDICINA GENERAL'],
            ['id' => 30, 'description' => 'MEDICINA INTERNA'],
            ['id' => 31, 'description' => 'NEFROLOGIA'],
            ['id' => 32, 'description' => 'NEUMOLOGIA'],
            ['id' => 33, 'description' => 'NEUMOLOGIA PEDIATRICA'],
            ['id' => 34, 'description' => 'NEUROCIRUGIA'],
            ['id' => 35, 'description' => 'NEUROLOGIA'],
            ['id' => 36, 'description' => 'NEUROLOGIA PEDIATRICA'],
            ['id' => 37, 'description' => 'NUTRICION'],
            ['id' => 38, 'description' => 'OBSTETRICIA'],
            ['id' => 39, 'description' => 'ODONTOLOGIA'],
            ['id' => 40, 'description' => 'ODONTOLOGIA PEDIATRICA'],
            ['id' => 41, 'description' => 'OFTALMOLOGIA'],
            ['id' => 42, 'description' => 'ONCOLOGIA MEDICA'],
            ['id' => 43, 'description' => 'ORTODONCIA'],
            ['id' => 44, 'description' => 'OTORRINOLARINGOLOGIA'],
            ['id' => 45, 'description' => 'OTORRINOLARINGOLOGIA PEDIATRICA'],
            ['id' => 46, 'description' => 'PEDIATRIA'],
            ['id' => 47, 'description' => 'PODOLOGIA'],
            ['id' => 48, 'description' => 'PSICOLOGIA'],
            ['id' => 49, 'description' => 'PSIQUIATRIA'],
            ['id' => 50, 'description' => 'REUMATOLOGIA'],
            ['id' => 51, 'description' => 'TRAUMATOLOGIA'],
            ['id' => 52, 'description' => 'UROLOGIA'],
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
