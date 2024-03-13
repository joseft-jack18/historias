<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Persons;
use App\Models\Procedures;
use Illuminate\Http\Request;
use App\Models\PersonHistory;
use App\Models\MedicalRecords;
use App\Models\MedicalDiagnoses;
use App\Models\MedicalWorkPlans;
use App\Models\MedicalProcedures;
use App\Models\MedicalTreatments;
use App\Models\MedicalInterconsultation;
use Illuminate\Support\Facades\DB;

class MedicalRecordsController extends Controller
{
    public function index($id)
    {
        $histories = MedicalRecords::where('person_id', $id)->orderBy('created_at', 'desc')->get();
        $numeracion = 1;

        return view('histories', compact('histories', 'numeracion'));
    }

    public function create($id)
    {
        $personHistory = PersonHistory::where('person_id', '=', $id)->first();
        $person = Persons::find($id);
        $person->age = Carbon::parse($person->birthdate)->age;

        return view('create_history', compact('person', 'personHistory'));
    }

    public function store(Request $request)
    {
        $presuntivos = json_decode($request->diagnosticosPresuntivos);
        $definitivos = json_decode($request->diagnosticosDefinitivos);
        $laboratorios = json_decode($request->examenesLaboratorio);
        $radiologicos = json_decode($request->examenesRadiologicos);
        $procedimientos = json_decode($request->procedimientosEspeciales);
        $interconsultas = json_decode($request->interconsultasMedicas);
        $tratamientos = json_decode($request->arrayTratamientos);

        //guardamos los antecedentes del paciente--------------------------------------------
        $personHistory = PersonHistory::find($request->post('person_id'));
        $personHistory->personal_history = $request->post('personal_history');
        $personHistory->allergies_history = $request->post('allergies_history');
        $personHistory->family_history = $request->post('family_history');
        $personHistory->updated_at = Carbon::now();
        $personHistory->save();

        //guardamos los datos de la historia del paciente------------------------------------
        $historia = new MedicalRecords();
        $historia->person_id = $request->post('person_id');
        $historia->quantity = $request->post('quantity');
        $historia->time = $request->post('time');
        $historia->reason_consultation = $request->post('reason_consultation');
        $historia->main_symptoms = $request->post('main_symptoms');
        $historia->thirst = $request->post('thirst');
        $historia->appetite = $request->post('appetite');
        $historia->dream = $request->post('dream');
        $historia->urinary_rhythm = $request->post('urinary_rhythm');
        $historia->evacuation_rhythm = $request->post('evacuation_rhythm');
        $historia->heart_rate = $request->post('heart_rate');
        $historia->breathing_frequency = $request->post('breathing_frequency');
        $historia->blood_pressure = $request->post('blood_pressure');
        $historia->temperature = $request->post('temperature');
        $historia->weight = $request->post('weight');
        $historia->sice = $request->post('size');
        $historia->imc = $request->post('imc');
        $historia->general_exam = $request->post('general_exam');
        $historia->preferential_exam = $request->post('preferential_exam');
        $historia->hygienic_measures = $request->post('hygienic_measures');
        $historia->observations = $request->post('observations');
        $historia->next_attention = $request->post('next_attention');
        $historia->created_at = Carbon::now();
        $historia->updated_at = Carbon::now();
        $historia->save();

        //guardamos los antecedentes del paciente--------------------------------------------
        $personHistory = PersonHistory::find($request->post('person_id'));
        $personHistory->personal_history = $request->post('personal_history');
        $personHistory->allergies_history = $request->post('allergies_history');
        $personHistory->family_history = $request->post('family_history');
        $personHistory->updated_at = Carbon::now();
        $personHistory->save();

        //guardamos los diagnosticos del paciente--------------------------------------------
        if(count($presuntivos) > 0){
            foreach($presuntivos as $presuntivo){
                $pre = new MedicalDiagnoses();
                $pre->history_id = $historia->id;
                $pre->diagnosis_id = $presuntivo->id;
                $pre->type = 'P';
                $pre->created_at = Carbon::now();
                $pre->updated_at = Carbon::now();
                $pre->save();
            }
        }

        if(count($definitivos) > 0){
            foreach($definitivos as $definitivo){
                $def = new MedicalDiagnoses();
                $def->history_id = $historia->id;
                $def->diagnosis_id = $definitivo->id;
                $def->type = 'D';
                $def->created_at = Carbon::now();
                $def->updated_at = Carbon::now();
                $def->save();
            }
        }

        //guardamos los laboratorios y las imagenes del paciente-----------------------------
        if(count($laboratorios) > 0){
            foreach($laboratorios as $laboratorio){
                $lab = new MedicalWorkPlans();
                $lab->history_id = $historia->id;
                $lab->procedure_id = $laboratorio->id;
                $lab->type = 'L';
                $lab->created_at = Carbon::now();
                $lab->updated_at = Carbon::now();
                $lab->save();
            }
        }

        if(count($radiologicos) > 0){
            foreach($radiologicos as $radiologico){
                $img = new MedicalWorkPlans();
                $img->history_id = $historia->id;
                $img->procedure_id = $radiologico->id;
                $img->type = 'I';
                $img->created_at = Carbon::now();
                $img->updated_at = Carbon::now();
                $img->save();
            }
        }

        //guardamos los procedimientos del paciente------------------------------------------
        if(count($procedimientos) > 0){
            foreach($procedimientos as $procedimiento){
                $pro = new MedicalProcedures();
                $pro->history_id = $historia->id;
                $pro->description = $procedimiento->text;
                $pro->created_at = Carbon::now();
                $pro->updated_at = Carbon::now();
                $pro->save();
            }
        }

        //guardamos las interconsultas del paciente------------------------------------------
        if(count($interconsultas) > 0){
            foreach($interconsultas as $interconsulta){
                $int = new MedicalInterconsultation();
                $int->history_id = $historia->id;
                $int->specialty_id = $interconsulta->id;
                $int->created_at = Carbon::now();
                $int->updated_at = Carbon::now();
                $int->save();
            }
        }

        //guardamos los tratamientos del paciente--------------------------------------------
        if(count($tratamientos) > 0){
            foreach($tratamientos as $tratamiento){
                $tra = new MedicalTreatments();
                $tra->history_id = $historia->id;
                $tra->medicine = $tratamiento->medicine;
                $tra->shape = $tratamiento->shape;
                $tra->dose = $tratamiento->dose;
                $tra->quantity = $tratamiento->quantity;
                $tra->indications = '';
                $tra->created_at = Carbon::now();
                $tra->updated_at = Carbon::now();
                $tra->save();
            }
        }

        return redirect()->route('history.index', $request->post('person_id'))->with('success','Historia creada correctamente');
    }

    public function pdf_procedures($id)
    {
        //$tomografias = Procedures::where('specialty_id', '=', 4)->get();
        $history = MedicalRecords::find($id);
        $person = Persons::find($history->person_id);
        $person->age = Carbon::parse($person->birthdate)->age;

        //dd($tomografias);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A5',
            'default_font_size' => 9,
            'default_font' => 'sans-serif',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 8
        ]);

        //estilos css-------------------------------------
        $mpdf->WriteHTML('
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
        ');

        //CUERPO HTML-------------------------------------------------------------------------------
        $mpdf->WriteHTML('<h3 class="titulo">LISTADO DE TOMOGRAFIAS</h3>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DATOS DEL PACIENTE</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">N° HISTORIA</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">EDAD</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">'. $person->name .'</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->number .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->age .' AÑOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE CABEZA</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE M. INFERIORES</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Cerebro</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Cadera + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Hipófisis</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Fémur + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Senos Paranasales</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Rodilla + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Macizo Facial</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Pierna + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Órbitas</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Tobillos + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Oídos</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Pie + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE ABDOMEN</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE COLUMNA</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Abdomen Superior</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Columna Lumbar + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Abdomen Inferior</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Columna Dorsal + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Abdomen Total</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Columna Cervical + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Hepático</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Sacroxocigea + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Pelvis</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%"></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE TÓRAX</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE CUELLO</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Tórax</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Cuello</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM (Tórax / HD)</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Tiroideas</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Mediastino</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%"></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS DE M. SUPERIORES</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%" class="subtitulo2">TOMOGRAFÍAS ANGIOGRÁFICAS</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">SC</td>');
        $mpdf->WriteHTML('<td style="width:5%" class="subtitulo2">CC</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Hombro + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Pulmonar</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Húmero + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Abdominal</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Codo + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Miembros Superiores</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Antebrazo + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Miembros Inferiores</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Muñeca + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Carótida</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:39%">TEM Mano + 3D</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:2%"></td>');
        $mpdf->WriteHTML('<td style="width:39%">Angio TEM Cerebral</td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" /></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->AddPage();

        //CUERPO HTML-------------------------------------------------------------------------------
        $mpdf->WriteHTML('<h3 class="titulo">LISTADO DE ECOGRAFIAS</h3>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DATOS DEL PACIENTE</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">N° HISTORIA</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">EDAD</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">'. $person->name .'</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->number .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->age .' AÑOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%; text-align: center" class="subtitulo2" colspan="3">ECOGRAFÍAS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Abdomen Completo</td>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Abdomen Superior</td>');
        $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Abdomen Inferior</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Cadera</td>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Cerebral Transfontanelar</td>');
        $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Hombro</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Mama</td>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Vesical</td>');
        $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Pared Toráxica y Pleuras</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Partes Blandas</td>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Pélvica</td>');
        $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Próstata y Vejiga</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Renal Vesical</td>');
        $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Rodilla</td>');
        $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Testicular</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%" colspan="3"><input type="radio" id="huey" name="drone" value="huey" /> ECO Músculo Esquelético (codo, muñeca, tobillo)</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%; text-align: center" class="subtitulo2" colspan="2">ECOGRAFÍAS GINECO OBSTÉTRICAS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Obstétrica</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Fetal</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Transvaginal</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> Ecografía 4D</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Genética</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Mamaria</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Monitoreo de Ovulación (por sesión)</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Morfológica</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Obstétrica</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Pélvica Transvesical</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Perfil Biofísico Fetal</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler de Ovarios, Útero y Anexos (transvaginal)</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%; text-align: center" class="subtitulo2" colspan="2">ECOGRAFÍAS </td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Arterial - Miembros Superiores</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Arterial - Miembros Inferiores</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Carotideo y Vertebral</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler de Mamas</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler del Sistema Porta</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Esplénico</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Mamaria</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Pélvica</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Renal</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Testicular</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Tiroides</td>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Venosos - Miembros Superiores</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" /> ECO Doppler Venosos - Miembros Inferiores</td>');
        $mpdf->WriteHTML('<td style="width:50%"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->AddPage();

        //CUERPO HTML-------------------------------------------------------------------------------
        $mpdf->WriteHTML('<h3 class="titulo">LISTADO DE RADIOGRAFÍAS</h3>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DATOS DEL PACIENTE</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">N° HISTORIA</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">EDAD</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">'. $person->name .'</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->number .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->age .' AÑOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX CABEZA Y CUELLO</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX COLUNA Y PELVIS</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX EXTREMIDADES</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Agujero Óptico F/P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación C1-C2</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Antebrazo F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Arco CIgomático</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación coxofemoral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Brazo - Húmero</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación Témporo Maxilar</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación sacroiliaca bilateral F-20B</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Calcáneo Corporativo</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación Témporo Maxilar Bilateral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Articulación sacroiliaca Unilateral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Calcáneo F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cavum</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cadera coxofemoral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Codo F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cráneo frontal y perfil</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cadera Lowestein</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Edad Osea</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Huesos propios de la nariz F/P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cadera Van Rossen</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Fémur</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Mastoides</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna cervical F-P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Hombro</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Maxilar superior</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna cervical F-P-O</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Hombro Comparativo</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Maxilar inferior</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna cervical Funcional</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Hombro funcional unilateral</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Órbitas</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna cervical dorsal</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Hombro funcional bilateral</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Peñasco cada lado</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna dorsal F-P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Mano F-O</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Senos paranasales</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna dorsal F-P-O</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Mano F-Lateral</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Silla Turca frontal y perfil</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna dorsal funcional</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Medición de miembros</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX TÓRAX</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna dorso lumbar</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Muñeca F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Clavícula Bilateral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna Lumbar</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Panorámico de Miembros</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Clavícula Unilateral</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna Lumbo sacra F-P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Pie</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Corazón y grandes vasos</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna Lumbo sacra F-P-O</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Pierna F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Esternón F-O</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna Lumbo sacra Funcional</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Pies Comparativos</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Parrilla Costal F-O</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna sacro coxigea F-P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Rodilla F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Tórax F</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Columna Panorámica</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Rótulo Bilateral</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Tórax F-P</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Pelvis</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Rótula F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX APARATO UROGENITAL</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX APARATO DIGESTIVO</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Survey Oseo</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cistografía</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Abdomen simple</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Tobillo comparativo</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Histerosalpingografía</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Abdomen simple de cúbito y pie</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Tobillo F-P</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Simple de aparato urinario</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Colangiografía postoperatoria</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX OTROS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Uretografía Retrógrada</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Colon doble contraste</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Cuerpo Extraño</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Urografía Excretoria</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Esofagograma</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Fistulografía</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"></td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Esófago, estómago y duodeno contraste X2</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:32%"></td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" /> Intestino delgado</td>');
        $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
        $mpdf->WriteHTML('<td style="width:32%"></td>');
        $mpdf->WriteHTML('</tr>');


        $mpdf->WriteHTML('</table>');

        return $mpdf->Output('procedimientos.pdf', 'I');
    }

    public function pdf_medical($id)
    {
        $medicamentos = MedicalTreatments::where('history_id', '=', $id)->get();
        $diagnosticos = DB::table('medical_diagnoses')
                        ->join('diagnoses', 'diagnoses.id', '=', 'medical_diagnoses.diagnosis_id')
                        ->select('diagnoses.internal_id', 'diagnoses.description', 'medical_diagnoses.type')
                        ->where('medical_diagnoses.history_id', '=', $id)
                        ->get();
        $history = MedicalRecords::find($id);
        $person = Persons::find($history->person_id);
        $person->age = Carbon::parse($person->birthdate)->age;

        //dd($diagnosticos);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A5',
            'default_font_size' => 8,
            'default_font' => 'sans-serif',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 8
        ]);

        //estilos css-------------------------------------
        $mpdf->WriteHTML('
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
        ');

        //CUERPO HTML-------------------------------------------------------------------------------
        $mpdf->WriteHTML('<h3 class="titulo">RECETA MÉDICA</h3>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DATOS DEL PACIENTE</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">N° HISTORIA</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">EDAD</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">'. $person->name .'</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->number .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->age .' AÑOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DIANÓSTICOS</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:15%; text-align: center" class="subtitulo2">CIE10</td>');
        $mpdf->WriteHTML('<td style="width:70%" class="subtitulo2">DIAGNÓSTICO</td>');
        $mpdf->WriteHTML('<td style="width:15%; text-align: center" class="subtitulo2">TIPO</td>');
        $mpdf->WriteHTML('</tr>');

        if(count($diagnosticos) > 0){
            foreach($diagnosticos as $diagnostico){
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:15%; text-align: center">'. $diagnostico->internal_id .'</td>');
            $mpdf->WriteHTML('<td style="width:70%">'. $diagnostico->description .'</td>');
            $mpdf->WriteHTML('<td style="width:15%; text-align: center">'. $diagnostico->type .'</td>');
            $mpdf->WriteHTML('</tr>');
            }
        } else {
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:100%; text-align: center">Sin Diagnósticos</td>');
            $mpdf->WriteHTML('</tr>');
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">MEDICAMENTOS</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; fontsize: 7px;">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:40%; text-align: center" class="subtitulo2">MEDICAMENTO</td>');
        $mpdf->WriteHTML('<td style="width:40%; text-align: center" class="subtitulo2">DOSIS</td>');
        $mpdf->WriteHTML('<td style="width:10%; text-align: center" class="subtitulo2">FORMA</td>');
        $mpdf->WriteHTML('<td style="width:10%; text-align: center" class="subtitulo2">CANT.</td>');
        $mpdf->WriteHTML('</tr>');

        if(count($medicamentos) > 0){
            foreach($medicamentos as $medicamento){
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:40%">'. $medicamento->medicine .'</td>');
            $mpdf->WriteHTML('<td style="width:40%">'. $medicamento->dose .'</td>');
            $mpdf->WriteHTML('<td style="width:10%; text-align: center">'. $medicamento->shape .'</td>');
            $mpdf->WriteHTML('<td style="width:10%; text-align: center">'. $medicamento->quantity .'</td>');
            $mpdf->WriteHTML('</tr>');
            }
        } else {
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:100%; text-align: center" colspan="4">Sin medicamentos</td>');
            $mpdf->WriteHTML('</tr>');
        }

        $mpdf->WriteHTML('</table>');

        return $mpdf->Output('receta.pdf', 'I');
    }

    public function pdf_history($id)
    {
        $history = MedicalRecords::find($id);
        $personHistory = PersonHistory::where('person_id', '=', $history->person_id)->first();
        $diagnoses_p = DB::table('medical_diagnoses')
                        ->join('diagnoses', 'diagnoses.id', '=', 'medical_diagnoses.diagnosis_id')
                        ->select('diagnoses.internal_id', 'diagnoses.description')
                        ->where('medical_diagnoses.history_id', '=', $id)
                        ->where('medical_diagnoses.type', '=', 'P')
                        ->get();
        $diagnoses_d = DB::table('medical_diagnoses')
                        ->join('diagnoses', 'diagnoses.id', '=', 'medical_diagnoses.diagnosis_id')
                        ->select('diagnoses.internal_id', 'diagnoses.description', 'medical_diagnoses.type')
                        ->where('medical_diagnoses.history_id', '=', $id)
                        ->where('medical_diagnoses.type', '=', 'D')
                        ->get();
        $laboratorios = DB::table('medical_work_plans')
                            ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                            ->select('procedures.type', 'procedures.description')
                            ->where('medical_work_plans.history_id', '=', $id)
                            ->where('medical_work_plans.type', '=', 'L')
                            ->get();
        $imagenes = DB::table('medical_work_plans')
                        ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                        ->select('procedures.type', 'procedures.description')
                        ->where('medical_work_plans.history_id', '=', $id)
                        ->where('medical_work_plans.type', '=', 'I')
                        ->get();
        $procedimientos = MedicalProcedures::where('history_id', '=', $id)->get();
        $interconsultas = DB::table('medical_interconsultation')
                            ->join('specialties', 'specialties.id', '=', 'medical_interconsultation.specialty_id')
                            ->select('specialties.description')
                            ->where('medical_interconsultation.history_id', '=', $id)
                            ->get();
        $treatments = MedicalTreatments::where('history_id', '=', $id)->get();
        $person = Persons::find($history->person_id);
        $person->age = Carbon::parse($person->birthdate)->age;

        if($history->time == 0){ $history->tiempo = '--'; }
        else if($history->time == 1) { $history->tiempo = 'Horas'; }
        else if($history->time == 2) { $history->tiempo = 'Días'; }
        else if($history->time == 3) { $history->tiempo = 'Meses'; }
        else if($history->time == 4) { $history->tiempo = 'Años'; }

        if($history->thirst == 0){ $history->sed = '--'; }
        else if($history->thirst == 1) { $history->sed = 'Disminuido'; }
        else if($history->thirst == 2) { $history->sed = 'Normal'; }
        else if($history->thirst == 3) { $history->sed = 'Aumentado'; }

        if($history->appetite == 0){ $history->apetito = '--'; }
        else if($history->appetite == 1) { $history->apetito = 'Disminuido'; }
        else if($history->appetite == 2) { $history->apetito = 'Normal'; }
        else if($history->appetite == 3) { $history->apetito = 'Aumentado'; }

        if($history->dream == 0){ $history->sueño = '--'; }
        else if($history->dream == 1) { $history->sueño = 'Disminuido'; }
        else if($history->dream == 2) { $history->sueño = 'Normal'; }
        else if($history->dream == 3) { $history->sueño = 'Aumentado'; }

        if($history->urinary_rhythm == 0){ $history->urinario = '--'; }
        else if($history->urinary_rhythm == 1) { $history->urinario = 'Disminuido'; }
        else if($history->urinary_rhythm == 2) { $history->urinario = 'Normal'; }
        else if($history->urinary_rhythm == 3) { $history->urinario = 'Aumentado'; }

        if($history->evacuation_rhythm == 0){ $history->evacuatorio = '--'; }
        else if($history->evacuation_rhythm == 1) { $history->evacuatorio = 'Disminuido'; }
        else if($history->evacuation_rhythm == 2) { $history->evacuatorio = 'Normal'; }
        else if($history->evacuation_rhythm == 3) { $history->evacuatorio = 'Aumentado'; }

        $diagnoses = count($diagnoses_p) + count($diagnoses_d);
        $plans = count($laboratorios) + count($imagenes) + count($procedimientos) + count($interconsultas);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'default_font' => 'sans-serif',
        ]);

        //ESTILOS CSS-------------------------------------------------------------------------------
        $mpdf->WriteHTML('
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
        ');

        //CUERPO HTML-------------------------------------------------------------------------------
        $mpdf->WriteHTML('<h3 class="titulo">HISTORIA CLINICA - CONSULTA EXTERNA</h3>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DATOS DEL PACIENTE</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">N° HISTORIA</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">EDAD</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">'. $person->name .'</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->number .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $person->age .' AÑOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%" class="subtitulo2">MEDICO</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">CMP</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">ATENCION</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:50%">PERCY MALDONADO MOGROVEJO</td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('<td style="width:20%">025131</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->updated_at .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">ENFERMEDAD ACTUAL</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:30%" class="subtitulo2">TIEMPO</td>');
        $mpdf->WriteHTML('<td style="width:70%" class="subtitulo2">MOTIVO DE CONSULTA</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:30%">'. ($history->quantity == null ? '--' : ($history->quantity.' '.$history->tiempo)) .'</td>');
        $mpdf->WriteHTML('<td style="width:70%">'. ($history->reason_consultation == null ? '--' : $history->reason_consultation) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">RELATO CRONOLOGICO</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($history->main_symptoms == null ? '--' : $history->main_symptoms) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">R. URINARIO</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">R. EVACUATORIO</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">SED</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">APETITO</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">SUEÑO</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->urinario .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->evacuatorio .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->sed .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->apetito .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. $history->sueño .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">ANTECEDENTES</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">ANTECEDENTES PERSONALES</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($personHistory->personal_history == '' ? '--' : $personHistory->personal_history) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">ANTECEDENTES DE ALERGIAS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($personHistory->allergies_history == '' ? '--' : $personHistory->allergies_history) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">ANTECEDENTES FAMILIARES</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($personHistory->family_history == '' ? '--' : $personHistory->family_history) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">EXAMEN FÍSICO</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%" class="subtitulo2">FRECUENCIA RESPIRATORIA</td>');
        $mpdf->WriteHTML('<td style="width:33%" class="subtitulo2">FRECUENCIA CARDÍACA</td>');
        $mpdf->WriteHTML('<td style="width:34%" class="subtitulo2">PRESIÓN ARTERIAL</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:33%">'. ($history->heart_rate == null ? '--' : ($history->heart_rate.' x min')) .'</td>');
        $mpdf->WriteHTML('<td style="width:33%">'. ($history->breathing_frequency == null ? '--' : ($history->breathing_frequency.' x min')) .'</td>');
        $mpdf->WriteHTML('<td style="width:34%">'. ($history->blood_pressure == null ? '--' : ($history->blood_pressure.' mmHg')) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:25%" class="subtitulo2">TEMPERATURA</td>');
        $mpdf->WriteHTML('<td style="width:25%" class="subtitulo2">PESO</td>');
        $mpdf->WriteHTML('<td style="width:25%" class="subtitulo2">TALLA</td>');
        $mpdf->WriteHTML('<td style="width:25%" class="subtitulo2">IMC</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:25%">'. ($history->temperature == null ? '--' : ($history->temperature.' °C')) .'</td>');
        $mpdf->WriteHTML('<td style="width:25%">'. ($history->weight == null ? '--' : ($history->weight.' KG')) .'</td>');
        $mpdf->WriteHTML('<td style="width:25%">'. ($history->sice == null ? '--' : ($history->sice.' M')) .'</td>');
        $mpdf->WriteHTML('<td style="width:25%">'. ($history->imc == null ? '--' : $history->imc) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">EXAMEN GENERAL</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($history->general_exam == null ? '--' : $history->general_exam) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">EXAMEN PREFERENCIAL</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($history->preferential_exam == null ? '--' : $history->preferential_exam) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        if($diagnoses > 0){

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DIAGNÓSTICOS</h3>');

        if(count($diagnoses_p) > 0){
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%; text-align: center;" class="subtitulo2">DIAGNÓSTICOS PRESUNTIVOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:15%" class="subtitulo2">CIE10</td>');
        $mpdf->WriteHTML('<td style="width:85%" class="subtitulo2">DIAGNÓSTICO</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($diagnoses_p as $diagnose_p){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:15%">'. $diagnose_p->internal_id .'</td>');
        $mpdf->WriteHTML('<td style="width:85%">'. $diagnose_p->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        $mpdf->WriteHTML('</table>');
        }

        if(count($diagnoses_d) > 0){
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%; text-align: center;" class="subtitulo2">DIAGNÓSTICOS DEFINITIVOS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:15%" class="subtitulo2">CIE10</td>');
        $mpdf->WriteHTML('<td style="width:85%" class="subtitulo2">DIAGNÓSTICO</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($diagnoses_d as $diagnose_d){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:15%">'. $diagnose_d->internal_id .'</td>');
        $mpdf->WriteHTML('<td style="width:85%">'. $diagnose_d->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        $mpdf->WriteHTML('</table>');
        }
        }

        if($plans > 0){
        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">PLAN DE TRABAJO</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        if(count($laboratorios) > 0){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">EXAMENES DE LABORATORIO</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($laboratorios as $laboratorio){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. $laboratorio->type . ' - ' . $laboratorio->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        }
        if(count($imagenes) > 0){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">EXAMENES RADIOLOGICOS</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($imagenes as $imagen){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. $imagen->type . ' - ' . $imagen->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        }
        if(count($procedimientos) > 0){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">PROCEDIMIENTOS ESPECIALES</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($procedimientos as $procedimiento){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. $procedimiento->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        }
        if(count($interconsultas) > 0){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">INTERCONSULTAS MEDICAS</td>');
        $mpdf->WriteHTML('</tr>');
        foreach($interconsultas as $interconsulta){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. $interconsulta->description .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        }
        $mpdf->WriteHTML('</table>');
        }

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">TRATAMIENTO</h3>');

        if(count($treatments) > 0){
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        foreach($treatments as $treatment){
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:40%" class="subtitulo2">MEDICAMENTO</td>');
        $mpdf->WriteHTML('<td style="width:40%" class="subtitulo2">DOSIS</td>');
        $mpdf->WriteHTML('<td style="width:10%" class="subtitulo2">FORMA</td>');
        $mpdf->WriteHTML('<td style="width:10%" class="subtitulo2">CANT.</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:40%">'. $treatment->medicine .'</td>');
        $mpdf->WriteHTML('<td style="width:40%">'. $treatment->dose .'</td>');
        $mpdf->WriteHTML('<td style="width:10%">'. $treatment->shape .'</td>');
        $mpdf->WriteHTML('<td style="width:10%">'. $treatment->quantity .'</td>');
        $mpdf->WriteHTML('</tr>');
        }
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        }

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">MEDIDAS HIGIÉNICAS DIETÉTICAS</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. ($history->hygienic_measures == null ? '--' : $history->hygienic_measures) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">OBSERVACIONES</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:80%" class="subtitulo2">OBSERVACIÓN</td>');
        $mpdf->WriteHTML('<td style="width:20%" class="subtitulo2">PRÓXIMA CITA</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:80%">'. ($history->observations == null ? '--' : $history->observations) .'</td>');
        $mpdf->WriteHTML('<td style="width:20%">'. ($history->next_attention == null ? '--' : $history->next_attention) .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        return $mpdf->Output('historia.pdf', 'I');
    }

    public function show(MedicalRecords $medicalRecords)
    {
        //
    }

    public function edit(MedicalRecords $medicalRecords)
    {
        //
    }

    public function update(Request $request, MedicalRecords $medicalRecords)
    {
        //
    }

    public function destroy(MedicalRecords $medicalRecords)
    {
        //
    }
}
