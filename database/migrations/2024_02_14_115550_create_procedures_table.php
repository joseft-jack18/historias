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
        Schema::create('procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('specialty_id');
            $table->string('type');
            $table->string('description');
            $table->timestamps();

            $table->foreign('specialty_id')->references('id')->on('specialties');
        });

        DB::table('procedures')->insert([
            ['id' => 1, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM CEREBRO S/C'],
            ['id' => 2, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM CEREBRO C/C'],
            ['id' => 3, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM HIPÓFISIS S/C'],
            ['id' => 4, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM HIPÓFISIS C/C'],
            ['id' => 5, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM SENOS PARANASALES S/C'],
            ['id' => 6, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM SENOS PARANASALES C/C'],
            ['id' => 7, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM MACIZO FACIAL S/C'],
            ['id' => 8, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM MACIZO FACIAL C/C'],
            ['id' => 9, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM ÓRBITAS S/C'],
            ['id' => 10, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM ÓRBITAS C/C'],
            ['id' => 11, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM OÍDOS S/C'],
            ['id' => 12, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CABEZA', 'description' => 'TEM OÍDOS C/C'],
            ['id' => 13, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN SUPERIOR S/C'],
            ['id' => 14, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN SUPERIOR C/C'],
            ['id' => 15, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN INFERIOR S/C'],
            ['id' => 16, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN INFERIOR C/C'],
            ['id' => 17, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN TOTAL S/C'],
            ['id' => 18, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM ABDOMEN TOTAL C/C'],
            ['id' => 19, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM HEPÁTICO S/C'],
            ['id' => 20, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM HEPÁTICO C/C'],
            ['id' => 21, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM PELVIS S/C'],
            ['id' => 22, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE ABDOMEN', 'description' => 'TEM PELVIS C/C'],
            ['id' => 23, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM TÓRAX S/C'],
            ['id' => 24, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM TÓRAX C/C'],
            ['id' => 25, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM (TÓRAX / HD) S/C'],
            ['id' => 26, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM (TÓRAX / HD) C/C'],
            ['id' => 27, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM MEDIASTINO S/C'],
            ['id' => 28, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE TÓRAX', 'description' => 'TEM MEDIASTINO C/C'],
            ['id' => 29, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM HOMBRO + 3D S/C'],
            ['id' => 30, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM HOMBRO + 3D C/C'],
            ['id' => 31, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM HÚMERO + 3D S/C'],
            ['id' => 32, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM HÚMERO + 3D C/C'],
            ['id' => 33, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM CODO + 3D S/C'],
            ['id' => 34, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM CODO + 3D C/C'],
            ['id' => 35, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM ANTEBRAZO + 3D S/C'],
            ['id' => 36, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM ANTEBRAZO + 3D C/C'],
            ['id' => 37, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM MUÑECA + 3D S/C'],
            ['id' => 38, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM MUÑECA + 3D C/C'],
            ['id' => 39, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM MANO + 3D S/C'],
            ['id' => 40, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS SUPERIORES', 'description' => 'TEM MANO + 3D C/C'],
            ['id' => 41, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM CADERA + 3D S/C'],
            ['id' => 42, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM CADERA + 3D C/C'],
            ['id' => 43, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM FÉMUR + 3D S/C'],
            ['id' => 44, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM FÉMUR + 3D C/C'],
            ['id' => 45, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM RODILLA + 3D S/C'],
            ['id' => 46, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM RODILLA + 3D C/C'],
            ['id' => 47, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM PIERNA + 3D S/C'],
            ['id' => 48, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM PIERNA + 3D C/C'],
            ['id' => 49, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM TOBILLOS + 3D S/C'],
            ['id' => 50, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM TOBILLOS + 3D C/C'],
            ['id' => 51, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM PIE + 3D S/C'],
            ['id' => 52, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE MIEMBROS INFERIORES', 'description' => 'TEM PIE + 3D C/C'],
            ['id' => 53, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA LUMBAR + 3D S/C'],
            ['id' => 54, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA LUMBAR + 3D C/C'],
            ['id' => 55, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA DORSAL + 3D S/C'],
            ['id' => 56, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA DORSAL + 3D C/C'],
            ['id' => 57, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA CERVICAL + 3D S/C'],
            ['id' => 58, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM COLUMNA CERVICAL + 3D C/C'],
            ['id' => 59, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM SACROXOCIGEA + 3D S/C'],
            ['id' => 60, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE COLUMNA', 'description' => 'TEM SACROXOCIGEA + 3D C/C'],
            ['id' => 61, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CUELLO', 'description' => 'TEM CUELLO S/C'],
            ['id' => 62, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CUELLO', 'description' => 'TEM CUELLO C/C'],
            ['id' => 63, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CUELLO', 'description' => 'TEM TIROIDEAS S/C'],
            ['id' => 64, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA DE CUELLO', 'description' => 'TEM TIROIDEAS C/C'],
            ['id' => 65, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM PULMONAR S/C'],
            ['id' => 66, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM PULMONAR C/C'],
            ['id' => 67, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM ABDOMINAL S/C'],
            ['id' => 68, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM ABDOMINAL C/C'],
            ['id' => 69, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM MIEMBROS SUPERIORES S/C'],
            ['id' => 70, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM MIEMBROS SUPERIORES C/C'],
            ['id' => 71, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM MIEMBROS INFERIORES S/C'],
            ['id' => 72, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM MIEMBROS INFERIORES C/C'],
            ['id' => 73, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM CARÓTIDA S/C'],
            ['id' => 74, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM CARÓTIDA C/C'],
            ['id' => 75, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM CEREBRAL S/C'],
            ['id' => 76, 'specialty_id' => 4, 'type' => 'TOMOGRAFIA ANGIOGRÁFICA', 'description' => 'ANGIO TEM CEREBRAL C/C'],
            ['id' => 77, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO ABDOMEN COMPLETO'],
            ['id' => 78, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO ABDOMEN SUPERIOR'],
            ['id' => 79, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO ABDOMEN INFERIOR'],
            ['id' => 80, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO CADERA'],
            ['id' => 81, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO CEREBRAL TRANSFONTANELAR'],
            ['id' => 82, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO HOMBRO'],
            ['id' => 83, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO MAMA'],
            ['id' => 84, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO MÚSCULO ESQUELÉTICO (CODO, MUÑECA, TOBILLO)'],
            ['id' => 85, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO PARED TORÁXICA Y PLEURAS'],
            ['id' => 86, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO PARTES BLANDAS'],
            ['id' => 87, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO PÉLVICA'],
            ['id' => 88, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO PRÓSTATA Y VEGIJA'],
            ['id' => 89, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO RENAL VESICAL'],
            ['id' => 90, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO RODILLA'],
            ['id' => 91, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO TESTICULAR'],
            ['id' => 92, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA', 'description' => 'ECO VESICAL'],
            ['id' => 93, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO DOPPLER DE OVARIOS, ÚTEROS Y ANEXOS (TRANSVAGINAL)'],
            ['id' => 94, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO DOPPLER OBSTÉTRICA'],
            ['id' => 95, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO DOPPLER FETAL'],
            ['id' => 96, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECOGRAFÍA 4D'],
            ['id' => 97, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO GENÉTICA'],
            ['id' => 98, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO MAMARIA'],
            ['id' => 99, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO MONITOREO DE OVULACIÓN (POR SESIÓN)'],
            ['id' => 100, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO MORFOLÓGICA'],
            ['id' => 101, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO OBSTÉTRICA'],
            ['id' => 102, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO PÉLVICA TRANSVESICAL'],
            ['id' => 103, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO PERFIL BIOFÍSICO FETAL'],
            ['id' => 104, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA GÍNECO OBSTÉTRICAS', 'description' => 'ECO TRANSVAGINAL'],
            ['id' => 105, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER ARTERIAL - MIEMBROS SUPERIORES'],
            ['id' => 106, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER ARTERIAL - MIEMBROS INFERIORES'],
            ['id' => 107, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER CAROTIDEO Y VERTEBRAL'],
            ['id' => 108, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER DE MAMAS'],
            ['id' => 109, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER DEL SISTEMA PORTA'],
            ['id' => 110, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER ESPLÉNICO'],
            ['id' => 111, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER MAMARIA'],
            ['id' => 112, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER PÉLVICA'],
            ['id' => 113, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER RENAL'],
            ['id' => 114, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER TESTICULAR'],
            ['id' => 115, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER TIROIDES'],
            ['id' => 116, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER VENOSOS - MIEMBROS SUPERIORES'],
            ['id' => 117, 'specialty_id' => 1, 'type' => 'ECOGRAFÍA DOPPLER', 'description' => 'ECO DOPPLER VENOSOS - MIEMBROS INFERIORES'],
            ['id' => 118, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'AGUJERO ÓPTICO F/P'],
            ['id' => 119, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'ARCO CIGOMÁTICO'],
            ['id' => 120, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'ARTICULACIÓN TÉMPORO MAXILAR'],
            ['id' => 121, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'ARTICULACIÓN TÉMPORO MAXILAR BILATERAL'],
            ['id' => 122, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'CAVUM'],
            ['id' => 123, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'CRÁNEO FRONTAL Y PERFIL'],
            ['id' => 124, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'HUESOS PROPIOS DE LA NARIZ F/P'],
            ['id' => 125, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'MASTOIDES'],
            ['id' => 126, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'MAXILAR SUPERIOR'],
            ['id' => 127, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'MAXILAR INFERIOR'],
            ['id' => 128, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'ÓRBITAS'],
            ['id' => 129, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'PEÑASCO CADA LADO'],
            ['id' => 130, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'SENOS PARANASALES'],
            ['id' => 131, 'specialty_id' => 3, 'type' => 'RX CABEZA Y CUELLO', 'description' => 'SILLA TURCA FRONTAL Y PERFIL'],
            ['id' => 132, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'CLAVÍCULA BILATERAL'],
            ['id' => 133, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'CLAVÍCULA UNILATERAL'],
            ['id' => 134, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'CORAZÓN Y GRANDES VASOS'],
            ['id' => 135, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'ESTERNÓN F-O'],
            ['id' => 136, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'PARRILLA COSTAL F-O'],
            ['id' => 137, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'TÓRAX F'],
            ['id' => 138, 'specialty_id' => 3, 'type' => 'RX TÓRAX', 'description' => 'TÓRAX F-P'],
            ['id' => 139, 'specialty_id' => 3, 'type' => 'RX APARATO UROGENITAL', 'description' => 'CISTOGRAFÍA'],
            ['id' => 140, 'specialty_id' => 3, 'type' => 'RX APARATO UROGENITAL', 'description' => 'HISTEROSALPINGOGRAFÍA'],
            ['id' => 141, 'specialty_id' => 3, 'type' => 'RX APARATO UROGENITAL', 'description' => 'SIMPLE DE APARATO URINARIO'],
            ['id' => 142, 'specialty_id' => 3, 'type' => 'RX APARATO UROGENITAL', 'description' => 'URETROGRAFÍA RETRÓGRADA'],
            ['id' => 143, 'specialty_id' => 3, 'type' => 'RX APARATO UROGENITAL', 'description' => 'UROGRAFÍA EXCRETORIA'],
            ['id' => 144, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'ARTICULACIÓN C1-C2'],
            ['id' => 145, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'ARTICULACIÓN COXOFEMORAL'],
            ['id' => 146, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'ARTICULACIÓN SACROILIACA BILATERAL F-20B'],
            ['id' => 147, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'ARTICULACIÓN SACROILIACA UNILATERAL'],
            ['id' => 148, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'CADERA COXOFEMORAL'],
            ['id' => 149, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'CADERA LOWESTEIN'],
            ['id' => 150, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'CADERA VAN ROSSEN'],
            ['id' => 151, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA CERVICAL F-P'],
            ['id' => 152, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA CERVICAL F-P-O'],
            ['id' => 153, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA CERVICAL FUNCIONAL'],
            ['id' => 154, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA CERVICAL DORSAL'],
            ['id' => 155, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA DORSAL F-P'],
            ['id' => 156, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA DORSAL F-P-O'],
            ['id' => 157, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA DORSAL FUNCIONAL'],
            ['id' => 158, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA DORSAL LUMBAR'],
            ['id' => 159, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA LUMBAR'],
            ['id' => 160, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA LUMBO SACRA F-P'],
            ['id' => 161, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA LUMBO SACRA F-P-O'],
            ['id' => 162, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA LUMBO SACRA FUNCIONAL'],
            ['id' => 163, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA SACRO COXIGEA F-P'],
            ['id' => 164, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'COLUMNA PANORÁMICA'],
            ['id' => 165, 'specialty_id' => 3, 'type' => 'RX COLUMNA Y PELVIS', 'description' => 'PELVIS'],
            ['id' => 166, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'ABDOMEN SIMPLE'],
            ['id' => 167, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'ABDOMEN SIMPLE DE CÚBITO Y PIE'],
            ['id' => 168, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'COLANGIOGRAFÍA POSTOPERATORIA'],
            ['id' => 169, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'COLON DOBLE CONTRASTE'],
            ['id' => 170, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'ESOFAGOGRAMA'],
            ['id' => 171, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'ESÓFAGO, ESTÓMAGO Y DUODENO CONTRASTE X2'],
            ['id' => 172, 'specialty_id' => 3, 'type' => 'RX APARATO DIGESTIVO', 'description' => 'INTESTINO DELGADO'],
            ['id' => 173, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'ANTEBRAZO F-P'],
            ['id' => 174, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'BRAZO - HÚMERO'],
            ['id' => 175, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'CALCÁNEO CORPORATIVO'],
            ['id' => 176, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'CALCÁNEO F-P'],
            ['id' => 177, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'CODO F-P'],
            ['id' => 178, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'EDAD ÓSEA'],
            ['id' => 179, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'FÉMUR'],
            ['id' => 180, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'HOMBRO'],
            ['id' => 181, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'HOMBRO COMPARATIVO'],
            ['id' => 182, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'HOMBRO FUNCIONAL UNILATERAL'],
            ['id' => 183, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'HOMBRO FUNCIONAL BILATERAL'],
            ['id' => 184, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'MANO F-O'],
            ['id' => 185, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'MANO F-LATERAL'],
            ['id' => 186, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'MEDICIÓN DE MIEMBROS'],
            ['id' => 187, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'MUÑECA F-P'],
            ['id' => 188, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'PANORÁMICO DE MIEMBROS'],
            ['id' => 189, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'PIE'],
            ['id' => 190, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'PIERNA F-P'],
            ['id' => 191, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'PIES COMPARATIVOS'],
            ['id' => 192, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'RODILLA F-P'],
            ['id' => 193, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'RÓTULO BILATERAL'],
            ['id' => 194, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'RÓTULA F-P'],
            ['id' => 195, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'SURVEY ÓSEO'],
            ['id' => 196, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'TOBILLO COMPARATIVO'],
            ['id' => 197, 'specialty_id' => 3, 'type' => 'RX EXTREMIDADES', 'description' => 'TOBILLO F-P'],
            ['id' => 198, 'specialty_id' => 3, 'type' => 'RX OTROS', 'description' => 'CUERPO EXTRAÑO'],
            ['id' => 199, 'specialty_id' => 3, 'type' => 'RX OTROS', 'description' => 'FISTULOGRAFÍA'],

            ['id' => 200, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'ACIDO URICO'],
            ['id' => 201, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'AMILASA'],
            ['id' => 202, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'BILIRRUBINAS TOTALES Y FRACCIONADAS'],
            ['id' => 203, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'BUN UREICO'],
            ['id' => 204, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'CALCIO IONICO'],
            ['id' => 205, 'specialty_id' => 2, 'type' => 'BIOQUIMICA', 'description' => 'CALCIO SERICO'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
};
