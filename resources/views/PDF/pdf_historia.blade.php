<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .titulo {
        text-align: center;
        background: #032691;
        color: #fff;
        padding: 4px;
    }
    .subtitulo {
        text-align: center;
        background: #DEDEDE;
        color: #032691;
        padding: 1px;
    }
    .subtitulo2 {
        background: #DEDEDE;
        color: #032691;
        font-weight: bold;
        padding: 3px 0px 3px 5px;
    }
</style>
<body>
    <h3 class="titulo">HISTORIA CLINICA - CONSULTA EXTERNA</h3>
    <h3 class="subtitulo">DATOS DEL PACIENTE</h3>

    <table cellspacing="0" style="width: 100%">
        <tr>
            <td style="width:50%" class="subtitulo2">PACIENTE</td>
            <td style="width:10%"></td>
            <td style="width:20%" class="subtitulo2">N° HISTORIA</td>
            <td style="width:20%" class="subtitulo2">EDAD</td>
        </tr>
        <tr>
            <td style="width:50%">{{ $person->name }}</td>
            <td style="width:10%"></td>
            <td style="width:20%">{{ $person->number }}</td>
            <td style="width:20%">{{ $person->age }} AÑOS</td>
        </tr>
        <tr>
            <td style="width:50%" class="subtitulo2">MEDICO</td>
            <td style="width:10%"></td>
            <td style="width:20%" class="subtitulo2">CMP</td>
            <td style="width:20%" class="subtitulo2">ATENCION</td>
        </tr>
        <tr>
            <td style="width:50%">PERCY MALDONADO MOGROVEJO</td>
            <td style="width:10%"></td>
            <td style="width:20%">025131</td>
            <td style="width:20%">{{ $history->updated_at }}</td>
        </tr>
    </table>

    <br>
    <h3 class="subtitulo">ENFERMEDAD ACTUAL</h3>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:30%" class="subtitulo2">TIEMPO</td>
    <td style="width:70%" class="subtitulo2">MOTIVO DE CONSULTA</td>
    </tr>
    <tr>
    <td style="width:30%">'. ($history->quantity == null ? '--' : ($history->quantity.' '.$history->tiempo)) .'</td>
    <td style="width:70%">'. ($history->reason_consultation == null ? '--' : $history->reason_consultation) .'</td>
    </tr>
    </table>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%" class="subtitulo2">RELATO CRONOLOGICO</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($history->main_symptoms == null ? '--' : $history->main_symptoms) .'</td>
    </tr>
    </table>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:20%" class="subtitulo2">R. URINARIO</td>
    <td style="width:20%" class="subtitulo2">R. EVACUATORIO</td>
    <td style="width:20%" class="subtitulo2">SED</td>
    <td style="width:20%" class="subtitulo2">APETITO</td>
    <td style="width:20%" class="subtitulo2">SUEÑO</td>
    </tr>
    <tr>
    <td style="width:20%">'. $history->urinario .'</td>
    <td style="width:20%">'. $history->evacuatorio .'</td>
    <td style="width:20%">'. $history->sed .'</td>
    <td style="width:20%">'. $history->apetito .'</td>
    <td style="width:20%">'. $history->sueño .'</td>
    </tr>
    </table>

    <br>
    <h3 class="subtitulo">ANTECEDENTES</h3>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%" class="subtitulo2">ANTECEDENTES PERSONALES</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($personHistory->personal_history == '' ? '--' : $personHistory->personal_history) .'</td>
    </tr>
    <tr>
    <td style="width:100%" class="subtitulo2">ANTECEDENTES DE ALERGIAS</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($personHistory->allergies_history == '' ? '--' : $personHistory->allergies_history) .'</td>
    </tr>
    <tr>
    <td style="width:100%" class="subtitulo2">ANTECEDENTES FAMILIARES</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($personHistory->family_history == '' ? '--' : $personHistory->family_history) .'</td>
    </tr>
    </table>

    <br>
    <h3 class="subtitulo">EXAMEN FÍSICO</h3>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:33%" class="subtitulo2">FRECUENCIA RESPIRATORIA</td>
    <td style="width:33%" class="subtitulo2">FRECUENCIA CARDÍACA</td>
    <td style="width:34%" class="subtitulo2">PRESIÓN ARTERIAL</td>
    </tr>
    <tr>
    <td style="width:33%">'. ($history->heart_rate == null ? '--' : ($history->heart_rate.' x min')) .'</td>
    <td style="width:33%">'. ($history->breathing_frequency == null ? '--' : ($history->breathing_frequency.' x min')) .'</td>
    <td style="width:34%">'. ($history->blood_pressure == null ? '--' : ($history->blood_pressure.' mmHg')) .'</td>
    </tr>
    </table>
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:25%" class="subtitulo2">TEMPERATURA</td>
    <td style="width:25%" class="subtitulo2">PESO</td>
    <td style="width:25%" class="subtitulo2">TALLA</td>
    <td style="width:25%" class="subtitulo2">IMC</td>
    </tr>
    <tr>
    <td style="width:25%">'. ($history->temperature == null ? '--' : ($history->temperature.' °C')) .'</td>
    <td style="width:25%">'. ($history->weight == null ? '--' : ($history->weight.' KG')) .'</td>
    <td style="width:25%">'. ($history->sice == null ? '--' : ($history->sice.' M')) .'</td>
    <td style="width:25%">'. ($history->imc == null ? '--' : $history->imc) .'</td>
    </tr>
    </table>
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%" class="subtitulo2">EXAMEN GENERAL</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($history->general_exam == null ? '--' : $history->general_exam) .'</td>
    </tr>
    <tr>
    <td style="width:100%" class="subtitulo2">EXAMEN PREFERENCIAL</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($history->preferential_exam == null ? '--' : $history->preferential_exam) .'</td>
    </tr>
    </table>


    <br>
    <h3 class="subtitulo">DIAGNÓSTICOS</h3>

    s_p) >
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%; text-align: center;" class="subtitulo2">DIAGNÓSTICOS PRESUNTIVOS</td>
    </tr>
    </table>
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:15%" class="subtitulo2">CIE10</td>
    <td style="width:85%" class="subtitulo2">DIAGNÓSTICO</td>
    </tr>
    _p as $diagnose_
    <tr>
    <td style="width:15%">'. $diagnose_p->internal_id .'</td>
    <td style="width:85%">'. $diagnose_p->description .'</td>
    </tr>
    </table>
    s_d) >
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%; text-align: center;" class="subtitulo2">DIAGNÓSTICOS DEFINITIVOS</td>
    </tr>
    </table>
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:15%" class="subtitulo2">CIE10</td>
    <td style="width:85%" class="subtitulo2">DIAGNÓSTICO</td>
    </tr>
    _d as $diagnose_
    <tr>
    <td style="width:15%">'. $diagnose_d->internal_id .'</td>
    <td style="width:85%">'. $diagnose_d->description .'</td>
    </tr>
    </table>
      <br>
    <h3 class="subtitulo">PLAN DE TRABAJO</h3>

    <table cellspacing="0" style="width: 100%">
    rios) >
    <tr>
    <td style="width:100%" class="subtitulo2">EXAMENES DE LABORATORIO</td>
    </tr>
    ios as $laboratori
    <tr>
    <td style="width:100%">'. $laboratorio->type . ' - ' . $laboratorio->description .'</td>
    </tr>
    ) >
    <tr>
    <td style="width:100%" class="subtitulo2">EXAMENES RADIOLOGICOS</td>
    </tr>
    as $image
    <tr>
    <td style="width:100%">'. $imagen->type . ' - ' . $imagen->description .'</td>
    </tr>
    ientos) >
    <tr>
    <td style="width:100%" class="subtitulo2">PROCEDIMIENTOS ESPECIALES</td>
    </tr>
    entos as $procedimient
    <tr>
    <td style="width:100%">'. $procedimiento->description .'</td>
    </tr>
    sultas) >
    <tr>
    <td style="width:100%" class="subtitulo2">INTERCONSULTAS MEDICAS</td>
    </tr>
    ultas as $interconsult
    <tr>
    <td style="width:100%">'. $interconsulta->description .'</td>
    </tr>
    </table>
    <br>
    <h3 class="subtitulo">TRATAMIENTO</h3>

    ts) >
    <table cellspacing="0" style="width: 100%">
    s as $treatmen
    <tr>
    <td style="width:40%" class="subtitulo2">MEDICAMENTO</td>
    <td style="width:40%" class="subtitulo2">DOSIS</td>
    <td style="width:10%" class="subtitulo2">FORMA</td>
    <td style="width:10%" class="subtitulo2">CANT.</td>
    </tr>
    <tr>
    <td style="width:40%">'. $treatment->medicine .'</td>
    <td style="width:40%">'. $treatment->dose .'</td>
    <td style="width:10%">'. $treatment->shape .'</td>
    <td style="width:10%">'. $treatment->quantity .'</td>
    </tr>
    </table>

    <br>
    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:100%" class="subtitulo2">MEDIDAS HIGIÉNICAS DIETÉTICAS</td>
    </tr>
    <tr>
    <td style="width:100%">'. ($history->hygienic_measures == null ? '--' : $history->hygienic_measures) .'</td>
    </tr>
    </table>

    <br>
    <h3 class="subtitulo">OBSERVACIONES</h3>

    <table cellspacing="0" style="width: 100%">
    <tr>
    <td style="width:80%" class="subtitulo2">OBSERVACIÓN</td>
    <td style="width:20%" class="subtitulo2">PRÓXIMA CITA</td>
    </tr>
    <tr>
    <td style="width:80%">'. ($history->observations == null ? '--' : $history->observations) .'</td>
    <td style="width:20%">'. ($history->next_attention == null ? '--' : $history->next_attention) .'</td>
    </tr>
    </table>
</body>
</html>
