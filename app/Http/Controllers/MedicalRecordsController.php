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
        $laboratorios = DB::table('medical_work_plans')
                        ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                        ->select('medical_work_plans.procedure_id')
                        ->where('medical_work_plans.history_id', '=', $id)
                        ->where('procedures.specialty_id', '=', 2)
                        ->get();
        $ecografias = DB::table('medical_work_plans')
                        ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                        ->select('medical_work_plans.procedure_id')
                        ->where('medical_work_plans.history_id', '=', $id)
                        ->where('procedures.specialty_id', '=', 1)
                        ->get();
        $radiografias = DB::table('medical_work_plans')
                        ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                        ->select('medical_work_plans.procedure_id')
                        ->where('medical_work_plans.history_id', '=', $id)
                        ->where('procedures.specialty_id', '=', 3)
                        ->get();
        $tomografias = DB::table('medical_work_plans')
                        ->join('procedures', 'procedures.id', '=', 'medical_work_plans.procedure_id')
                        ->select('medical_work_plans.procedure_id')
                        ->where('medical_work_plans.history_id', '=', $id)
                        ->where('procedures.specialty_id', '=', 4)
                        ->get();

        $history = MedicalRecords::find($id);
        $person = Persons::find($history->person_id);
        $person->age = Carbon::parse($person->birthdate)->age;

        $respTomografias = [];
        foreach($tomografias as $tomografia){
            $respTomografias[] = $tomografia->procedure_id;
        }

        if (in_array(1, $respTomografias)) { $data1 = 'checked=""'; } else { $data1 = ''; }
        if (in_array(2, $respTomografias)) { $data2 = 'checked=""'; } else { $data2 = ''; }
        if (in_array(3, $respTomografias)) { $data3 = 'checked=""'; } else { $data3 = ''; }
        if (in_array(4, $respTomografias)) { $data4 = 'checked=""'; } else { $data4 = ''; }
        if (in_array(5, $respTomografias)) { $data5 = 'checked=""'; } else { $data5 = ''; }
        if (in_array(6, $respTomografias)) { $data6 = 'checked=""'; } else { $data6 = ''; }
        if (in_array(7, $respTomografias)) { $data7 = 'checked=""'; } else { $data7 = ''; }
        if (in_array(8, $respTomografias)) { $data8 = 'checked=""'; } else { $data8 = ''; }
        if (in_array(9, $respTomografias)) { $data9 = 'checked=""'; } else { $data9 = ''; }
        if (in_array(10, $respTomografias)) { $data10 = 'checked=""'; } else { $data10 = ''; }
        if (in_array(11, $respTomografias)) { $data11 = 'checked=""'; } else { $data11 = ''; }
        if (in_array(12, $respTomografias)) { $data12 = 'checked=""'; } else { $data12 = ''; }
        if (in_array(13, $respTomografias)) { $data13 = 'checked=""'; } else { $data13 = ''; }
        if (in_array(14, $respTomografias)) { $data14 = 'checked=""'; } else { $data14 = ''; }
        if (in_array(15, $respTomografias)) { $data15 = 'checked=""'; } else { $data15 = ''; }
        if (in_array(16, $respTomografias)) { $data16 = 'checked=""'; } else { $data16 = ''; }
        if (in_array(17, $respTomografias)) { $data17 = 'checked=""'; } else { $data17 = ''; }
        if (in_array(18, $respTomografias)) { $data18 = 'checked=""'; } else { $data18 = ''; }
        if (in_array(19, $respTomografias)) { $data19 = 'checked=""'; } else { $data19 = ''; }
        if (in_array(20, $respTomografias)) { $data20 = 'checked=""'; } else { $data20 = ''; }
        if (in_array(21, $respTomografias)) { $data21 = 'checked=""'; } else { $data21 = ''; }
        if (in_array(22, $respTomografias)) { $data22 = 'checked=""'; } else { $data22 = ''; }
        if (in_array(23, $respTomografias)) { $data23 = 'checked=""'; } else { $data23 = ''; }
        if (in_array(24, $respTomografias)) { $data24 = 'checked=""'; } else { $data24 = ''; }
        if (in_array(25, $respTomografias)) { $data25 = 'checked=""'; } else { $data25 = ''; }
        if (in_array(26, $respTomografias)) { $data26 = 'checked=""'; } else { $data26 = ''; }
        if (in_array(27, $respTomografias)) { $data27 = 'checked=""'; } else { $data27 = ''; }
        if (in_array(28, $respTomografias)) { $data28 = 'checked=""'; } else { $data28 = ''; }
        if (in_array(29, $respTomografias)) { $data29 = 'checked=""'; } else { $data29 = ''; }
        if (in_array(30, $respTomografias)) { $data30 = 'checked=""'; } else { $data30 = ''; }
        if (in_array(31, $respTomografias)) { $data31 = 'checked=""'; } else { $data31 = ''; }
        if (in_array(32, $respTomografias)) { $data32 = 'checked=""'; } else { $data32 = ''; }
        if (in_array(33, $respTomografias)) { $data33 = 'checked=""'; } else { $data33 = ''; }
        if (in_array(34, $respTomografias)) { $data34 = 'checked=""'; } else { $data34 = ''; }
        if (in_array(35, $respTomografias)) { $data35 = 'checked=""'; } else { $data35 = ''; }
        if (in_array(36, $respTomografias)) { $data36 = 'checked=""'; } else { $data36 = ''; }
        if (in_array(37, $respTomografias)) { $data37 = 'checked=""'; } else { $data37 = ''; }
        if (in_array(38, $respTomografias)) { $data38 = 'checked=""'; } else { $data38 = ''; }
        if (in_array(39, $respTomografias)) { $data39 = 'checked=""'; } else { $data39 = ''; }
        if (in_array(40, $respTomografias)) { $data40 = 'checked=""'; } else { $data40 = ''; }
        if (in_array(41, $respTomografias)) { $data41 = 'checked=""'; } else { $data41 = ''; }
        if (in_array(42, $respTomografias)) { $data42 = 'checked=""'; } else { $data42 = ''; }
        if (in_array(43, $respTomografias)) { $data43 = 'checked=""'; } else { $data43 = ''; }
        if (in_array(44, $respTomografias)) { $data44 = 'checked=""'; } else { $data44 = ''; }
        if (in_array(45, $respTomografias)) { $data45 = 'checked=""'; } else { $data45 = ''; }
        if (in_array(46, $respTomografias)) { $data46 = 'checked=""'; } else { $data46 = ''; }
        if (in_array(47, $respTomografias)) { $data47 = 'checked=""'; } else { $data47 = ''; }
        if (in_array(48, $respTomografias)) { $data48 = 'checked=""'; } else { $data48 = ''; }
        if (in_array(49, $respTomografias)) { $data49 = 'checked=""'; } else { $data49 = ''; }
        if (in_array(50, $respTomografias)) { $data50 = 'checked=""'; } else { $data50 = ''; }
        if (in_array(51, $respTomografias)) { $data51 = 'checked=""'; } else { $data51 = ''; }
        if (in_array(52, $respTomografias)) { $data52 = 'checked=""'; } else { $data52 = ''; }
        if (in_array(53, $respTomografias)) { $data53 = 'checked=""'; } else { $data53 = ''; }
        if (in_array(54, $respTomografias)) { $data54 = 'checked=""'; } else { $data54 = ''; }
        if (in_array(55, $respTomografias)) { $data55 = 'checked=""'; } else { $data55 = ''; }
        if (in_array(56, $respTomografias)) { $data56 = 'checked=""'; } else { $data56 = ''; }
        if (in_array(57, $respTomografias)) { $data57 = 'checked=""'; } else { $data57 = ''; }
        if (in_array(58, $respTomografias)) { $data58 = 'checked=""'; } else { $data58 = ''; }
        if (in_array(59, $respTomografias)) { $data59 = 'checked=""'; } else { $data59 = ''; }
        if (in_array(60, $respTomografias)) { $data60 = 'checked=""'; } else { $data60 = ''; }
        if (in_array(61, $respTomografias)) { $data61 = 'checked=""'; } else { $data61 = ''; }
        if (in_array(62, $respTomografias)) { $data62 = 'checked=""'; } else { $data62 = ''; }
        if (in_array(63, $respTomografias)) { $data63 = 'checked=""'; } else { $data63 = ''; }
        if (in_array(64, $respTomografias)) { $data64 = 'checked=""'; } else { $data64 = ''; }
        if (in_array(65, $respTomografias)) { $data65 = 'checked=""'; } else { $data65 = ''; }
        if (in_array(66, $respTomografias)) { $data66 = 'checked=""'; } else { $data66 = ''; }
        if (in_array(67, $respTomografias)) { $data67 = 'checked=""'; } else { $data67 = ''; }
        if (in_array(68, $respTomografias)) { $data68 = 'checked=""'; } else { $data68 = ''; }
        if (in_array(69, $respTomografias)) { $data69 = 'checked=""'; } else { $data69 = ''; }
        if (in_array(70, $respTomografias)) { $data70 = 'checked=""'; } else { $data70 = ''; }
        if (in_array(71, $respTomografias)) { $data71 = 'checked=""'; } else { $data71 = ''; }
        if (in_array(72, $respTomografias)) { $data72 = 'checked=""'; } else { $data72 = ''; }
        if (in_array(73, $respTomografias)) { $data73 = 'checked=""'; } else { $data73 = ''; }
        if (in_array(74, $respTomografias)) { $data74 = 'checked=""'; } else { $data74 = ''; }
        if (in_array(75, $respTomografias)) { $data75 = 'checked=""'; } else { $data75 = ''; }
        if (in_array(76, $respTomografias)) { $data76 = 'checked=""'; } else { $data76 = ''; }


        $respEcografias = [];
        foreach($ecografias as $ecografia){
            $respEcografias[] = $ecografia->procedure_id;
        }

        if (in_array(77, $respEcografias)) { $data77 = 'checked=""'; } else { $data77 = ''; }
        if (in_array(78, $respEcografias)) { $data78 = 'checked=""'; } else { $data78 = ''; }
        if (in_array(79, $respEcografias)) { $data79 = 'checked=""'; } else { $data79 = ''; }
        if (in_array(80, $respEcografias)) { $data80 = 'checked=""'; } else { $data80 = ''; }
        if (in_array(81, $respEcografias)) { $data81 = 'checked=""'; } else { $data81 = ''; }
        if (in_array(82, $respEcografias)) { $data82 = 'checked=""'; } else { $data82 = ''; }
        if (in_array(83, $respEcografias)) { $data83 = 'checked=""'; } else { $data83 = ''; }
        if (in_array(84, $respEcografias)) { $data84 = 'checked=""'; } else { $data84 = ''; }
        if (in_array(85, $respEcografias)) { $data85 = 'checked=""'; } else { $data85 = ''; }
        if (in_array(86, $respEcografias)) { $data86 = 'checked=""'; } else { $data86 = ''; }
        if (in_array(87, $respEcografias)) { $data87 = 'checked=""'; } else { $data87 = ''; }
        if (in_array(88, $respEcografias)) { $data88 = 'checked=""'; } else { $data88 = ''; }
        if (in_array(89, $respEcografias)) { $data89 = 'checked=""'; } else { $data89 = ''; }
        if (in_array(90, $respEcografias)) { $data90 = 'checked=""'; } else { $data90 = ''; }
        if (in_array(91, $respEcografias)) { $data91 = 'checked=""'; } else { $data91 = ''; }
        if (in_array(92, $respEcografias)) { $data92 = 'checked=""'; } else { $data92 = ''; }
        if (in_array(93, $respEcografias)) { $data93 = 'checked=""'; } else { $data93 = ''; }
        if (in_array(94, $respEcografias)) { $data94 = 'checked=""'; } else { $data94 = ''; }
        if (in_array(95, $respEcografias)) { $data95 = 'checked=""'; } else { $data95 = ''; }
        if (in_array(96, $respEcografias)) { $data96 = 'checked=""'; } else { $data96 = ''; }
        if (in_array(97, $respEcografias)) { $data97 = 'checked=""'; } else { $data97 = ''; }
        if (in_array(98, $respEcografias)) { $data98 = 'checked=""'; } else { $data98 = ''; }
        if (in_array(99, $respEcografias)) { $data99 = 'checked=""'; } else { $data99 = ''; }
        if (in_array(100, $respEcografias)) { $data100 = 'checked=""'; } else { $data100 = ''; }
        if (in_array(101, $respEcografias)) { $data101 = 'checked=""'; } else { $data101 = ''; }
        if (in_array(102, $respEcografias)) { $data102 = 'checked=""'; } else { $data102 = ''; }
        if (in_array(103, $respEcografias)) { $data103 = 'checked=""'; } else { $data103 = ''; }
        if (in_array(104, $respEcografias)) { $data104 = 'checked=""'; } else { $data104 = ''; }
        if (in_array(105, $respEcografias)) { $data105 = 'checked=""'; } else { $data105 = ''; }
        if (in_array(106, $respEcografias)) { $data106 = 'checked=""'; } else { $data106 = ''; }
        if (in_array(107, $respEcografias)) { $data107 = 'checked=""'; } else { $data107 = ''; }
        if (in_array(108, $respEcografias)) { $data108 = 'checked=""'; } else { $data108 = ''; }
        if (in_array(109, $respEcografias)) { $data109 = 'checked=""'; } else { $data109 = ''; }
        if (in_array(110, $respEcografias)) { $data110 = 'checked=""'; } else { $data110 = ''; }
        if (in_array(111, $respEcografias)) { $data111 = 'checked=""'; } else { $data111 = ''; }
        if (in_array(112, $respEcografias)) { $data112 = 'checked=""'; } else { $data112 = ''; }
        if (in_array(113, $respEcografias)) { $data113 = 'checked=""'; } else { $data113 = ''; }
        if (in_array(114, $respEcografias)) { $data114 = 'checked=""'; } else { $data114 = ''; }
        if (in_array(115, $respEcografias)) { $data115 = 'checked=""'; } else { $data115 = ''; }
        if (in_array(116, $respEcografias)) { $data116 = 'checked=""'; } else { $data116 = ''; }
        if (in_array(117, $respEcografias)) { $data117 = 'checked=""'; } else { $data117 = ''; }


        $respRadiografias = [];
        foreach($radiografias as $radiografia){
            $respRadiografias[] = $radiografia->procedure_id;
        }

        if (in_array(118, $respRadiografias)) { $data118 = 'checked=""'; } else { $data118 = ''; }
        if (in_array(119, $respRadiografias)) { $data119 = 'checked=""'; } else { $data119 = ''; }
        if (in_array(120, $respRadiografias)) { $data120 = 'checked=""'; } else { $data120 = ''; }
        if (in_array(121, $respRadiografias)) { $data121 = 'checked=""'; } else { $data121 = ''; }
        if (in_array(122, $respRadiografias)) { $data122 = 'checked=""'; } else { $data122 = ''; }
        if (in_array(123, $respRadiografias)) { $data123 = 'checked=""'; } else { $data123 = ''; }
        if (in_array(124, $respRadiografias)) { $data124 = 'checked=""'; } else { $data124 = ''; }
        if (in_array(125, $respRadiografias)) { $data125 = 'checked=""'; } else { $data125 = ''; }
        if (in_array(126, $respRadiografias)) { $data126 = 'checked=""'; } else { $data126 = ''; }
        if (in_array(127, $respRadiografias)) { $data127 = 'checked=""'; } else { $data127 = ''; }
        if (in_array(128, $respRadiografias)) { $data128 = 'checked=""'; } else { $data128 = ''; }
        if (in_array(129, $respRadiografias)) { $data129 = 'checked=""'; } else { $data129 = ''; }
        if (in_array(130, $respRadiografias)) { $data130 = 'checked=""'; } else { $data130 = ''; }
        if (in_array(131, $respRadiografias)) { $data131 = 'checked=""'; } else { $data131 = ''; }
        if (in_array(132, $respRadiografias)) { $data132 = 'checked=""'; } else { $data132 = ''; }
        if (in_array(133, $respRadiografias)) { $data133 = 'checked=""'; } else { $data133 = ''; }
        if (in_array(134, $respRadiografias)) { $data134 = 'checked=""'; } else { $data134 = ''; }
        if (in_array(135, $respRadiografias)) { $data135 = 'checked=""'; } else { $data135 = ''; }
        if (in_array(136, $respRadiografias)) { $data136 = 'checked=""'; } else { $data136 = ''; }
        if (in_array(137, $respRadiografias)) { $data137 = 'checked=""'; } else { $data137 = ''; }
        if (in_array(138, $respRadiografias)) { $data138 = 'checked=""'; } else { $data138 = ''; }
        if (in_array(139, $respRadiografias)) { $data139 = 'checked=""'; } else { $data139 = ''; }
        if (in_array(140, $respRadiografias)) { $data140 = 'checked=""'; } else { $data140 = ''; }
        if (in_array(141, $respRadiografias)) { $data141 = 'checked=""'; } else { $data141 = ''; }
        if (in_array(142, $respRadiografias)) { $data142 = 'checked=""'; } else { $data142 = ''; }
        if (in_array(143, $respRadiografias)) { $data143 = 'checked=""'; } else { $data143 = ''; }
        if (in_array(144, $respRadiografias)) { $data144 = 'checked=""'; } else { $data144 = ''; }
        if (in_array(145, $respRadiografias)) { $data145 = 'checked=""'; } else { $data145 = ''; }
        if (in_array(146, $respRadiografias)) { $data146 = 'checked=""'; } else { $data146 = ''; }
        if (in_array(147, $respRadiografias)) { $data147 = 'checked=""'; } else { $data147 = ''; }
        if (in_array(148, $respRadiografias)) { $data148 = 'checked=""'; } else { $data148 = ''; }
        if (in_array(149, $respRadiografias)) { $data149 = 'checked=""'; } else { $data149 = ''; }
        if (in_array(150, $respRadiografias)) { $data150 = 'checked=""'; } else { $data150 = ''; }
        if (in_array(151, $respRadiografias)) { $data151 = 'checked=""'; } else { $data151 = ''; }
        if (in_array(152, $respRadiografias)) { $data152 = 'checked=""'; } else { $data152 = ''; }
        if (in_array(153, $respRadiografias)) { $data153 = 'checked=""'; } else { $data153 = ''; }
        if (in_array(154, $respRadiografias)) { $data154 = 'checked=""'; } else { $data154 = ''; }
        if (in_array(155, $respRadiografias)) { $data155 = 'checked=""'; } else { $data155 = ''; }
        if (in_array(156, $respRadiografias)) { $data156 = 'checked=""'; } else { $data156 = ''; }
        if (in_array(157, $respRadiografias)) { $data157 = 'checked=""'; } else { $data157 = ''; }
        if (in_array(158, $respRadiografias)) { $data158 = 'checked=""'; } else { $data158 = ''; }
        if (in_array(159, $respRadiografias)) { $data159 = 'checked=""'; } else { $data159 = ''; }
        if (in_array(160, $respRadiografias)) { $data160 = 'checked=""'; } else { $data160 = ''; }
        if (in_array(161, $respRadiografias)) { $data161 = 'checked=""'; } else { $data161 = ''; }
        if (in_array(162, $respRadiografias)) { $data162 = 'checked=""'; } else { $data162 = ''; }
        if (in_array(163, $respRadiografias)) { $data163 = 'checked=""'; } else { $data163 = ''; }
        if (in_array(164, $respRadiografias)) { $data164 = 'checked=""'; } else { $data164 = ''; }
        if (in_array(165, $respRadiografias)) { $data165 = 'checked=""'; } else { $data165 = ''; }
        if (in_array(166, $respRadiografias)) { $data166 = 'checked=""'; } else { $data166 = ''; }
        if (in_array(167, $respRadiografias)) { $data167 = 'checked=""'; } else { $data167 = ''; }
        if (in_array(168, $respRadiografias)) { $data168 = 'checked=""'; } else { $data168 = ''; }
        if (in_array(169, $respRadiografias)) { $data169 = 'checked=""'; } else { $data169 = ''; }
        if (in_array(170, $respRadiografias)) { $data170 = 'checked=""'; } else { $data170 = ''; }
        if (in_array(171, $respRadiografias)) { $data171 = 'checked=""'; } else { $data171 = ''; }
        if (in_array(172, $respRadiografias)) { $data172 = 'checked=""'; } else { $data172 = ''; }
        if (in_array(173, $respRadiografias)) { $data173 = 'checked=""'; } else { $data173 = ''; }
        if (in_array(174, $respRadiografias)) { $data174 = 'checked=""'; } else { $data174 = ''; }
        if (in_array(175, $respRadiografias)) { $data175 = 'checked=""'; } else { $data175 = ''; }
        if (in_array(176, $respRadiografias)) { $data176 = 'checked=""'; } else { $data176 = ''; }
        if (in_array(177, $respRadiografias)) { $data177 = 'checked=""'; } else { $data177 = ''; }
        if (in_array(178, $respRadiografias)) { $data178 = 'checked=""'; } else { $data178 = ''; }
        if (in_array(179, $respRadiografias)) { $data179 = 'checked=""'; } else { $data179 = ''; }
        if (in_array(180, $respRadiografias)) { $data180 = 'checked=""'; } else { $data180 = ''; }
        if (in_array(181, $respRadiografias)) { $data181 = 'checked=""'; } else { $data181 = ''; }
        if (in_array(182, $respRadiografias)) { $data182 = 'checked=""'; } else { $data182 = ''; }
        if (in_array(183, $respRadiografias)) { $data183 = 'checked=""'; } else { $data183 = ''; }
        if (in_array(184, $respRadiografias)) { $data184 = 'checked=""'; } else { $data184 = ''; }
        if (in_array(185, $respRadiografias)) { $data185 = 'checked=""'; } else { $data185 = ''; }
        if (in_array(186, $respRadiografias)) { $data186 = 'checked=""'; } else { $data186 = ''; }
        if (in_array(187, $respRadiografias)) { $data187 = 'checked=""'; } else { $data187 = ''; }
        if (in_array(188, $respRadiografias)) { $data188 = 'checked=""'; } else { $data188 = ''; }
        if (in_array(189, $respRadiografias)) { $data189 = 'checked=""'; } else { $data189 = ''; }
        if (in_array(190, $respRadiografias)) { $data190 = 'checked=""'; } else { $data190 = ''; }
        if (in_array(191, $respRadiografias)) { $data191 = 'checked=""'; } else { $data191 = ''; }
        if (in_array(192, $respRadiografias)) { $data192 = 'checked=""'; } else { $data192 = ''; }
        if (in_array(193, $respRadiografias)) { $data193 = 'checked=""'; } else { $data193 = ''; }
        if (in_array(194, $respRadiografias)) { $data194 = 'checked=""'; } else { $data194 = ''; }
        if (in_array(195, $respRadiografias)) { $data195 = 'checked=""'; } else { $data195 = ''; }
        if (in_array(196, $respRadiografias)) { $data196 = 'checked=""'; } else { $data196 = ''; }
        if (in_array(197, $respRadiografias)) { $data197 = 'checked=""'; } else { $data197 = ''; }
        if (in_array(198, $respRadiografias)) { $data198 = 'checked=""'; } else { $data198 = ''; }
        if (in_array(199, $respRadiografias)) { $data199 = 'checked=""'; } else { $data199 = ''; }


        $respLaboratorios = [];
        foreach($laboratorios as $laboratorio){
            $respLaboratorios[] = $laboratorio->procedure_id;
        }

        if (in_array(200, $respLaboratorios)) { $data200 = 'checked=""'; } else { $data200 = ''; }
        if (in_array(201, $respLaboratorios)) { $data201 = 'checked=""'; } else { $data201 = ''; }
        if (in_array(202, $respLaboratorios)) { $data202 = 'checked=""'; } else { $data202 = ''; }
        if (in_array(203, $respLaboratorios)) { $data203 = 'checked=""'; } else { $data203 = ''; }
        if (in_array(204, $respLaboratorios)) { $data204 = 'checked=""'; } else { $data204 = ''; }
        if (in_array(205, $respLaboratorios)) { $data205 = 'checked=""'; } else { $data205 = ''; }
        if (in_array(206, $respLaboratorios)) { $data206 = 'checked=""'; } else { $data206 = ''; }
        if (in_array(207, $respLaboratorios)) { $data207 = 'checked=""'; } else { $data207 = ''; }
        if (in_array(208, $respLaboratorios)) { $data208 = 'checked=""'; } else { $data208 = ''; }
        if (in_array(209, $respLaboratorios)) { $data209 = 'checked=""'; } else { $data209 = ''; }
        if (in_array(210, $respLaboratorios)) { $data210 = 'checked=""'; } else { $data210 = ''; }
        if (in_array(211, $respLaboratorios)) { $data211 = 'checked=""'; } else { $data211 = ''; }
        if (in_array(212, $respLaboratorios)) { $data212 = 'checked=""'; } else { $data212 = ''; }
        if (in_array(213, $respLaboratorios)) { $data213 = 'checked=""'; } else { $data213 = ''; }
        if (in_array(214, $respLaboratorios)) { $data214 = 'checked=""'; } else { $data214 = ''; }
        if (in_array(215, $respLaboratorios)) { $data215 = 'checked=""'; } else { $data215 = ''; }
        if (in_array(216, $respLaboratorios)) { $data216 = 'checked=""'; } else { $data216 = ''; }
        if (in_array(217, $respLaboratorios)) { $data217 = 'checked=""'; } else { $data217 = ''; }
        if (in_array(218, $respLaboratorios)) { $data218 = 'checked=""'; } else { $data218 = ''; }
        if (in_array(219, $respLaboratorios)) { $data219 = 'checked=""'; } else { $data219 = ''; }
        if (in_array(220, $respLaboratorios)) { $data220 = 'checked=""'; } else { $data220 = ''; }
        if (in_array(221, $respLaboratorios)) { $data221 = 'checked=""'; } else { $data221 = ''; }
        if (in_array(222, $respLaboratorios)) { $data222 = 'checked=""'; } else { $data222 = ''; }
        if (in_array(223, $respLaboratorios)) { $data223 = 'checked=""'; } else { $data223 = ''; }
        if (in_array(224, $respLaboratorios)) { $data224 = 'checked=""'; } else { $data224 = ''; }
        if (in_array(225, $respLaboratorios)) { $data225 = 'checked=""'; } else { $data225 = ''; }
        if (in_array(226, $respLaboratorios)) { $data226 = 'checked=""'; } else { $data226 = ''; }
        if (in_array(227, $respLaboratorios)) { $data227 = 'checked=""'; } else { $data227 = ''; }
        if (in_array(228, $respLaboratorios)) { $data228 = 'checked=""'; } else { $data228 = ''; }
        if (in_array(229, $respLaboratorios)) { $data229 = 'checked=""'; } else { $data229 = ''; }
        if (in_array(230, $respLaboratorios)) { $data230 = 'checked=""'; } else { $data230 = ''; }
        if (in_array(231, $respLaboratorios)) { $data231 = 'checked=""'; } else { $data231 = ''; }
        if (in_array(232, $respLaboratorios)) { $data232 = 'checked=""'; } else { $data232 = ''; }
        if (in_array(233, $respLaboratorios)) { $data233 = 'checked=""'; } else { $data233 = ''; }
        if (in_array(234, $respLaboratorios)) { $data234 = 'checked=""'; } else { $data234 = ''; }
        if (in_array(235, $respLaboratorios)) { $data235 = 'checked=""'; } else { $data235 = ''; }
        if (in_array(236, $respLaboratorios)) { $data236 = 'checked=""'; } else { $data236 = ''; }
        if (in_array(237, $respLaboratorios)) { $data237 = 'checked=""'; } else { $data237 = ''; }
        if (in_array(238, $respLaboratorios)) { $data238 = 'checked=""'; } else { $data238 = ''; }
        if (in_array(239, $respLaboratorios)) { $data239 = 'checked=""'; } else { $data239 = ''; }
        if (in_array(240, $respLaboratorios)) { $data240 = 'checked=""'; } else { $data240 = ''; }
        if (in_array(241, $respLaboratorios)) { $data241 = 'checked=""'; } else { $data241 = ''; }
        if (in_array(242, $respLaboratorios)) { $data242 = 'checked=""'; } else { $data242 = ''; }
        if (in_array(243, $respLaboratorios)) { $data243 = 'checked=""'; } else { $data243 = ''; }
        if (in_array(244, $respLaboratorios)) { $data244 = 'checked=""'; } else { $data244 = ''; }
        if (in_array(245, $respLaboratorios)) { $data245 = 'checked=""'; } else { $data245 = ''; }
        if (in_array(246, $respLaboratorios)) { $data246 = 'checked=""'; } else { $data246 = ''; }
        if (in_array(247, $respLaboratorios)) { $data247 = 'checked=""'; } else { $data247 = ''; }
        if (in_array(248, $respLaboratorios)) { $data248 = 'checked=""'; } else { $data248 = ''; }
        if (in_array(249, $respLaboratorios)) { $data249 = 'checked=""'; } else { $data249 = ''; }
        if (in_array(250, $respLaboratorios)) { $data250 = 'checked=""'; } else { $data250 = ''; }
        if (in_array(251, $respLaboratorios)) { $data251 = 'checked=""'; } else { $data251 = ''; }
        if (in_array(252, $respLaboratorios)) { $data252 = 'checked=""'; } else { $data252 = ''; }
        if (in_array(253, $respLaboratorios)) { $data253 = 'checked=""'; } else { $data253 = ''; }
        if (in_array(254, $respLaboratorios)) { $data254 = 'checked=""'; } else { $data254 = ''; }
        if (in_array(255, $respLaboratorios)) { $data255 = 'checked=""'; } else { $data255 = ''; }
        if (in_array(256, $respLaboratorios)) { $data256 = 'checked=""'; } else { $data256 = ''; }
        if (in_array(257, $respLaboratorios)) { $data257 = 'checked=""'; } else { $data257 = ''; }
        if (in_array(258, $respLaboratorios)) { $data258 = 'checked=""'; } else { $data258 = ''; }
        if (in_array(259, $respLaboratorios)) { $data259 = 'checked=""'; } else { $data259 = ''; }
        if (in_array(260, $respLaboratorios)) { $data260 = 'checked=""'; } else { $data260 = ''; }
        if (in_array(261, $respLaboratorios)) { $data261 = 'checked=""'; } else { $data261 = ''; }
        if (in_array(262, $respLaboratorios)) { $data262 = 'checked=""'; } else { $data262 = ''; }
        if (in_array(263, $respLaboratorios)) { $data263 = 'checked=""'; } else { $data263 = ''; }
        if (in_array(264, $respLaboratorios)) { $data264 = 'checked=""'; } else { $data264 = ''; }
        if (in_array(265, $respLaboratorios)) { $data265 = 'checked=""'; } else { $data265 = ''; }
        if (in_array(266, $respLaboratorios)) { $data266 = 'checked=""'; } else { $data266 = ''; }
        if (in_array(267, $respLaboratorios)) { $data267 = 'checked=""'; } else { $data267 = ''; }
        if (in_array(268, $respLaboratorios)) { $data268 = 'checked=""'; } else { $data268 = ''; }
        if (in_array(269, $respLaboratorios)) { $data269 = 'checked=""'; } else { $data269 = ''; }
        if (in_array(270, $respLaboratorios)) { $data270 = 'checked=""'; } else { $data270 = ''; }
        if (in_array(271, $respLaboratorios)) { $data271 = 'checked=""'; } else { $data271 = ''; }
        if (in_array(272, $respLaboratorios)) { $data272 = 'checked=""'; } else { $data272 = ''; }
        if (in_array(273, $respLaboratorios)) { $data273 = 'checked=""'; } else { $data273 = ''; }
        if (in_array(274, $respLaboratorios)) { $data274 = 'checked=""'; } else { $data274 = ''; }
        if (in_array(275, $respLaboratorios)) { $data275 = 'checked=""'; } else { $data275 = ''; }
        if (in_array(276, $respLaboratorios)) { $data276 = 'checked=""'; } else { $data276 = ''; }
        if (in_array(277, $respLaboratorios)) { $data277 = 'checked=""'; } else { $data277 = ''; }
        if (in_array(278, $respLaboratorios)) { $data278 = 'checked=""'; } else { $data278 = ''; }
        if (in_array(279, $respLaboratorios)) { $data279 = 'checked=""'; } else { $data279 = ''; }
        if (in_array(280, $respLaboratorios)) { $data280 = 'checked=""'; } else { $data280 = ''; }
        if (in_array(281, $respLaboratorios)) { $data281 = 'checked=""'; } else { $data281 = ''; }
        if (in_array(282, $respLaboratorios)) { $data282 = 'checked=""'; } else { $data282 = ''; }
        if (in_array(283, $respLaboratorios)) { $data283 = 'checked=""'; } else { $data283 = ''; }
        if (in_array(284, $respLaboratorios)) { $data284 = 'checked=""'; } else { $data284 = ''; }
        if (in_array(285, $respLaboratorios)) { $data285 = 'checked=""'; } else { $data285 = ''; }
        if (in_array(286, $respLaboratorios)) { $data286 = 'checked=""'; } else { $data286 = ''; }
        if (in_array(287, $respLaboratorios)) { $data287 = 'checked=""'; } else { $data287 = ''; }
        if (in_array(288, $respLaboratorios)) { $data288 = 'checked=""'; } else { $data288 = ''; }
        if (in_array(289, $respLaboratorios)) { $data289 = 'checked=""'; } else { $data289 = ''; }
        if (in_array(290, $respLaboratorios)) { $data290 = 'checked=""'; } else { $data290 = ''; }
        if (in_array(291, $respLaboratorios)) { $data291 = 'checked=""'; } else { $data291 = ''; }
        if (in_array(292, $respLaboratorios)) { $data292 = 'checked=""'; } else { $data292 = ''; }
        if (in_array(293, $respLaboratorios)) { $data293 = 'checked=""'; } else { $data293 = ''; }
        if (in_array(294, $respLaboratorios)) { $data294 = 'checked=""'; } else { $data294 = ''; }
        if (in_array(295, $respLaboratorios)) { $data295 = 'checked=""'; } else { $data295 = ''; }
        if (in_array(296, $respLaboratorios)) { $data296 = 'checked=""'; } else { $data296 = ''; }
        if (in_array(297, $respLaboratorios)) { $data297 = 'checked=""'; } else { $data297 = ''; }
        if (in_array(298, $respLaboratorios)) { $data298 = 'checked=""'; } else { $data298 = ''; }
        if (in_array(299, $respLaboratorios)) { $data299 = 'checked=""'; } else { $data299 = ''; }
        if (in_array(300, $respLaboratorios)) { $data300 = 'checked=""'; } else { $data300 = ''; }
        if (in_array(301, $respLaboratorios)) { $data301 = 'checked=""'; } else { $data301 = ''; }
        if (in_array(302, $respLaboratorios)) { $data302 = 'checked=""'; } else { $data302 = ''; }
        if (in_array(303, $respLaboratorios)) { $data303 = 'checked=""'; } else { $data303 = ''; }
        if (in_array(304, $respLaboratorios)) { $data304 = 'checked=""'; } else { $data304 = ''; }
        if (in_array(305, $respLaboratorios)) { $data305 = 'checked=""'; } else { $data305 = ''; }
        if (in_array(306, $respLaboratorios)) { $data306 = 'checked=""'; } else { $data306 = ''; }
        if (in_array(307, $respLaboratorios)) { $data307 = 'checked=""'; } else { $data307 = ''; }
        if (in_array(308, $respLaboratorios)) { $data308 = 'checked=""'; } else { $data308 = ''; }
        if (in_array(309, $respLaboratorios)) { $data309 = 'checked=""'; } else { $data309 = ''; }
        if (in_array(310, $respLaboratorios)) { $data310 = 'checked=""'; } else { $data310 = ''; }
        if (in_array(311, $respLaboratorios)) { $data311 = 'checked=""'; } else { $data311 = ''; }
        if (in_array(312, $respLaboratorios)) { $data312 = 'checked=""'; } else { $data312 = ''; }
        if (in_array(313, $respLaboratorios)) { $data313 = 'checked=""'; } else { $data313 = ''; }
        if (in_array(314, $respLaboratorios)) { $data314 = 'checked=""'; } else { $data314 = ''; }
        if (in_array(315, $respLaboratorios)) { $data315 = 'checked=""'; } else { $data315 = ''; }
        if (in_array(316, $respLaboratorios)) { $data316 = 'checked=""'; } else { $data316 = ''; }
        if (in_array(317, $respLaboratorios)) { $data317 = 'checked=""'; } else { $data317 = ''; }
        if (in_array(318, $respLaboratorios)) { $data318 = 'checked=""'; } else { $data318 = ''; }
        if (in_array(319, $respLaboratorios)) { $data319 = 'checked=""'; } else { $data319 = ''; }
        if (in_array(320, $respLaboratorios)) { $data320 = 'checked=""'; } else { $data320 = ''; }
        if (in_array(321, $respLaboratorios)) { $data321 = 'checked=""'; } else { $data321 = ''; }
        if (in_array(322, $respLaboratorios)) { $data322 = 'checked=""'; } else { $data322 = ''; }
        if (in_array(323, $respLaboratorios)) { $data323 = 'checked=""'; } else { $data323 = ''; }
        if (in_array(324, $respLaboratorios)) { $data324 = 'checked=""'; } else { $data324 = ''; }
        if (in_array(325, $respLaboratorios)) { $data325 = 'checked=""'; } else { $data325 = ''; }
        if (in_array(326, $respLaboratorios)) { $data326 = 'checked=""'; } else { $data326 = ''; }
        if (in_array(327, $respLaboratorios)) { $data327 = 'checked=""'; } else { $data327 = ''; }
        if (in_array(328, $respLaboratorios)) { $data328 = 'checked=""'; } else { $data328 = ''; }
        if (in_array(329, $respLaboratorios)) { $data329 = 'checked=""'; } else { $data329 = ''; }
        if (in_array(330, $respLaboratorios)) { $data330 = 'checked=""'; } else { $data330 = ''; }
        if (in_array(331, $respLaboratorios)) { $data331 = 'checked=""'; } else { $data331 = ''; }
        if (in_array(332, $respLaboratorios)) { $data332 = 'checked=""'; } else { $data332 = ''; }
        if (in_array(333, $respLaboratorios)) { $data333 = 'checked=""'; } else { $data333 = ''; }
        if (in_array(334, $respLaboratorios)) { $data334 = 'checked=""'; } else { $data334 = ''; }
        if (in_array(335, $respLaboratorios)) { $data335 = 'checked=""'; } else { $data335 = ''; }
        if (in_array(336, $respLaboratorios)) { $data336 = 'checked=""'; } else { $data336 = ''; }
        if (in_array(337, $respLaboratorios)) { $data337 = 'checked=""'; } else { $data337 = ''; }
        if (in_array(338, $respLaboratorios)) { $data338 = 'checked=""'; } else { $data338 = ''; }
        if (in_array(339, $respLaboratorios)) { $data339 = 'checked=""'; } else { $data339 = ''; }
        if (in_array(340, $respLaboratorios)) { $data340 = 'checked=""'; } else { $data340 = ''; }
        if (in_array(341, $respLaboratorios)) { $data341 = 'checked=""'; } else { $data341 = ''; }
        if (in_array(342, $respLaboratorios)) { $data342 = 'checked=""'; } else { $data342 = ''; }
        if (in_array(343, $respLaboratorios)) { $data343 = 'checked=""'; } else { $data343 = ''; }
        if (in_array(344, $respLaboratorios)) { $data344 = 'checked=""'; } else { $data344 = ''; }
        if (in_array(345, $respLaboratorios)) { $data345 = 'checked=""'; } else { $data345 = ''; }
        if (in_array(346, $respLaboratorios)) { $data346 = 'checked=""'; } else { $data346 = ''; }
        if (in_array(347, $respLaboratorios)) { $data347 = 'checked=""'; } else { $data347 = ''; }
        if (in_array(348, $respLaboratorios)) { $data348 = 'checked=""'; } else { $data348 = ''; }
        if (in_array(349, $respLaboratorios)) { $data349 = 'checked=""'; } else { $data349 = ''; }
        if (in_array(350, $respLaboratorios)) { $data350 = 'checked=""'; } else { $data350 = ''; }
        if (in_array(351, $respLaboratorios)) { $data351 = 'checked=""'; } else { $data351 = ''; }
        if (in_array(352, $respLaboratorios)) { $data352 = 'checked=""'; } else { $data352 = ''; }
        if (in_array(353, $respLaboratorios)) { $data353 = 'checked=""'; } else { $data353 = ''; }
        if (in_array(354, $respLaboratorios)) { $data354 = 'checked=""'; } else { $data354 = ''; }
        if (in_array(355, $respLaboratorios)) { $data355 = 'checked=""'; } else { $data355 = ''; }
        if (in_array(356, $respLaboratorios)) { $data356 = 'checked=""'; } else { $data356 = ''; }
        if (in_array(357, $respLaboratorios)) { $data357 = 'checked=""'; } else { $data357 = ''; }
        if (in_array(358, $respLaboratorios)) { $data358 = 'checked=""'; } else { $data358 = ''; }
        if (in_array(359, $respLaboratorios)) { $data359 = 'checked=""'; } else { $data359 = ''; }
        if (in_array(360, $respLaboratorios)) { $data360 = 'checked=""'; } else { $data360 = ''; }
        if (in_array(361, $respLaboratorios)) { $data361 = 'checked=""'; } else { $data361 = ''; }
        if (in_array(362, $respLaboratorios)) { $data362 = 'checked=""'; } else { $data362 = ''; }
        if (in_array(363, $respLaboratorios)) { $data363 = 'checked=""'; } else { $data363 = ''; }
        if (in_array(364, $respLaboratorios)) { $data364 = 'checked=""'; } else { $data364 = ''; }
        if (in_array(365, $respLaboratorios)) { $data365 = 'checked=""'; } else { $data365 = ''; }
        if (in_array(366, $respLaboratorios)) { $data366 = 'checked=""'; } else { $data366 = ''; }
        if (in_array(367, $respLaboratorios)) { $data367 = 'checked=""'; } else { $data367 = ''; }
        if (in_array(368, $respLaboratorios)) { $data368 = 'checked=""'; } else { $data368 = ''; }
        if (in_array(369, $respLaboratorios)) { $data369 = 'checked=""'; } else { $data369 = ''; }
        if (in_array(370, $respLaboratorios)) { $data370 = 'checked=""'; } else { $data370 = ''; }
        if (in_array(371, $respLaboratorios)) { $data371 = 'checked=""'; } else { $data371 = ''; }
        if (in_array(372, $respLaboratorios)) { $data372 = 'checked=""'; } else { $data372 = ''; }
        if (in_array(373, $respLaboratorios)) { $data373 = 'checked=""'; } else { $data373 = ''; }
        if (in_array(374, $respLaboratorios)) { $data374 = 'checked=""'; } else { $data374 = ''; }
        if (in_array(375, $respLaboratorios)) { $data375 = 'checked=""'; } else { $data375 = ''; }
        if (in_array(376, $respLaboratorios)) { $data376 = 'checked=""'; } else { $data376 = ''; }
        if (in_array(377, $respLaboratorios)) { $data377 = 'checked=""'; } else { $data377 = ''; }
        if (in_array(378, $respLaboratorios)) { $data378 = 'checked=""'; } else { $data378 = ''; }
        if (in_array(379, $respLaboratorios)) { $data379 = 'checked=""'; } else { $data379 = ''; }
        if (in_array(380, $respLaboratorios)) { $data380 = 'checked=""'; } else { $data380 = ''; }
        if (in_array(381, $respLaboratorios)) { $data381 = 'checked=""'; } else { $data381 = ''; }
        if (in_array(382, $respLaboratorios)) { $data382 = 'checked=""'; } else { $data382 = ''; }
        if (in_array(383, $respLaboratorios)) { $data383 = 'checked=""'; } else { $data383 = ''; }
        if (in_array(384, $respLaboratorios)) { $data384 = 'checked=""'; } else { $data384 = ''; }
        if (in_array(385, $respLaboratorios)) { $data385 = 'checked=""'; } else { $data385 = ''; }
        if (in_array(386, $respLaboratorios)) { $data386 = 'checked=""'; } else { $data386 = ''; }
        if (in_array(387, $respLaboratorios)) { $data387 = 'checked=""'; } else { $data387 = ''; }
        if (in_array(388, $respLaboratorios)) { $data388 = 'checked=""'; } else { $data388 = ''; }
        if (in_array(389, $respLaboratorios)) { $data389 = 'checked=""'; } else { $data389 = ''; }
        if (in_array(390, $respLaboratorios)) { $data390 = 'checked=""'; } else { $data390 = ''; }
        if (in_array(391, $respLaboratorios)) { $data391 = 'checked=""'; } else { $data391 = ''; }
        if (in_array(392, $respLaboratorios)) { $data392 = 'checked=""'; } else { $data392 = ''; }
        if (in_array(393, $respLaboratorios)) { $data393 = 'checked=""'; } else { $data393 = ''; }
        if (in_array(394, $respLaboratorios)) { $data394 = 'checked=""'; } else { $data394 = ''; }
        if (in_array(395, $respLaboratorios)) { $data395 = 'checked=""'; } else { $data395 = ''; }
        if (in_array(396, $respLaboratorios)) { $data396 = 'checked=""'; } else { $data396 = ''; }
        if (in_array(397, $respLaboratorios)) { $data397 = 'checked=""'; } else { $data397 = ''; }
        if (in_array(398, $respLaboratorios)) { $data398 = 'checked=""'; } else { $data398 = ''; }
        if (in_array(399, $respLaboratorios)) { $data399 = 'checked=""'; } else { $data399 = ''; }
        if (in_array(400, $respLaboratorios)) { $data400 = 'checked=""'; } else { $data400 = ''; }
        if (in_array(401, $respLaboratorios)) { $data401 = 'checked=""'; } else { $data401 = ''; }
        if (in_array(402, $respLaboratorios)) { $data402 = 'checked=""'; } else { $data402 = ''; }
        if (in_array(403, $respLaboratorios)) { $data403 = 'checked=""'; } else { $data403 = ''; }
        if (in_array(404, $respLaboratorios)) { $data404 = 'checked=""'; } else { $data404 = ''; }
        if (in_array(405, $respLaboratorios)) { $data405 = 'checked=""'; } else { $data405 = ''; }
        if (in_array(406, $respLaboratorios)) { $data406 = 'checked=""'; } else { $data406 = ''; }
        if (in_array(407, $respLaboratorios)) { $data407 = 'checked=""'; } else { $data407 = ''; }
        if (in_array(408, $respLaboratorios)) { $data408 = 'checked=""'; } else { $data408 = ''; }
        if (in_array(409, $respLaboratorios)) { $data409 = 'checked=""'; } else { $data409 = ''; }
        if (in_array(410, $respLaboratorios)) { $data410 = 'checked=""'; } else { $data410 = ''; }
        if (in_array(411, $respLaboratorios)) { $data411 = 'checked=""'; } else { $data411 = ''; }
        if (in_array(412, $respLaboratorios)) { $data412 = 'checked=""'; } else { $data412 = ''; }
        if (in_array(413, $respLaboratorios)) { $data413 = 'checked=""'; } else { $data413 = ''; }
        if (in_array(414, $respLaboratorios)) { $data414 = 'checked=""'; } else { $data414 = ''; }
        if (in_array(415, $respLaboratorios)) { $data415 = 'checked=""'; } else { $data415 = ''; }
        if (in_array(416, $respLaboratorios)) { $data416 = 'checked=""'; } else { $data416 = ''; }
        if (in_array(417, $respLaboratorios)) { $data417 = 'checked=""'; } else { $data417 = ''; }
        if (in_array(418, $respLaboratorios)) { $data418 = 'checked=""'; } else { $data418 = ''; }
        if (in_array(419, $respLaboratorios)) { $data419 = 'checked=""'; } else { $data419 = ''; }
        if (in_array(420, $respLaboratorios)) { $data420 = 'checked=""'; } else { $data420 = ''; }
        if (in_array(421, $respLaboratorios)) { $data421 = 'checked=""'; } else { $data421 = ''; }
        if (in_array(422, $respLaboratorios)) { $data422 = 'checked=""'; } else { $data422 = ''; }
        if (in_array(423, $respLaboratorios)) { $data423 = 'checked=""'; } else { $data423 = ''; }
        if (in_array(424, $respLaboratorios)) { $data424 = 'checked=""'; } else { $data424 = ''; }
        if (in_array(425, $respLaboratorios)) { $data425 = 'checked=""'; } else { $data425 = ''; }
        if (in_array(426, $respLaboratorios)) { $data426 = 'checked=""'; } else { $data426 = ''; }
        if (in_array(427, $respLaboratorios)) { $data427 = 'checked=""'; } else { $data427 = ''; }
        if (in_array(428, $respLaboratorios)) { $data428 = 'checked=""'; } else { $data428 = ''; }
        if (in_array(429, $respLaboratorios)) { $data429 = 'checked=""'; } else { $data429 = ''; }
        if (in_array(430, $respLaboratorios)) { $data430 = 'checked=""'; } else { $data430 = ''; }
        if (in_array(431, $respLaboratorios)) { $data431 = 'checked=""'; } else { $data431 = ''; }
        if (in_array(432, $respLaboratorios)) { $data432 = 'checked=""'; } else { $data432 = ''; }
        if (in_array(433, $respLaboratorios)) { $data433 = 'checked=""'; } else { $data433 = ''; }
        if (in_array(434, $respLaboratorios)) { $data434 = 'checked=""'; } else { $data434 = ''; }
        if (in_array(435, $respLaboratorios)) { $data435 = 'checked=""'; } else { $data435 = ''; }
        if (in_array(436, $respLaboratorios)) { $data436 = 'checked=""'; } else { $data436 = ''; }
        if (in_array(437, $respLaboratorios)) { $data437 = 'checked=""'; } else { $data437 = ''; }
        if (in_array(438, $respLaboratorios)) { $data438 = 'checked=""'; } else { $data438 = ''; }
        if (in_array(439, $respLaboratorios)) { $data439 = 'checked=""'; } else { $data439 = ''; }
        if (in_array(440, $respLaboratorios)) { $data440 = 'checked=""'; } else { $data440 = ''; }
        if (in_array(441, $respLaboratorios)) { $data441 = 'checked=""'; } else { $data441 = ''; }
        if (in_array(442, $respLaboratorios)) { $data442 = 'checked=""'; } else { $data442 = ''; }
        if (in_array(443, $respLaboratorios)) { $data443 = 'checked=""'; } else { $data443 = ''; }
        if (in_array(444, $respLaboratorios)) { $data444 = 'checked=""'; } else { $data444 = ''; }
        if (in_array(445, $respLaboratorios)) { $data445 = 'checked=""'; } else { $data445 = ''; }
        if (in_array(446, $respLaboratorios)) { $data446 = 'checked=""'; } else { $data446 = ''; }
        if (in_array(447, $respLaboratorios)) { $data447 = 'checked=""'; } else { $data447 = ''; }
        if (in_array(448, $respLaboratorios)) { $data448 = 'checked=""'; } else { $data448 = ''; }
        if (in_array(449, $respLaboratorios)) { $data449 = 'checked=""'; } else { $data449 = ''; }
        if (in_array(450, $respLaboratorios)) { $data450 = 'checked=""'; } else { $data450 = ''; }
        if (in_array(451, $respLaboratorios)) { $data451 = 'checked=""'; } else { $data451 = ''; }
        if (in_array(452, $respLaboratorios)) { $data452 = 'checked=""'; } else { $data452 = ''; }
        if (in_array(453, $respLaboratorios)) { $data453 = 'checked=""'; } else { $data453 = ''; }
        if (in_array(454, $respLaboratorios)) { $data454 = 'checked=""'; } else { $data454 = ''; }
        if (in_array(455, $respLaboratorios)) { $data455 = 'checked=""'; } else { $data455 = ''; }
        if (in_array(456, $respLaboratorios)) { $data456 = 'checked=""'; } else { $data456 = ''; }
        if (in_array(457, $respLaboratorios)) { $data457 = 'checked=""'; } else { $data457 = ''; }
        if (in_array(458, $respLaboratorios)) { $data458 = 'checked=""'; } else { $data458 = ''; }
        if (in_array(459, $respLaboratorios)) { $data459 = 'checked=""'; } else { $data459 = ''; }
        if (in_array(460, $respLaboratorios)) { $data460 = 'checked=""'; } else { $data460 = ''; }
        if (in_array(461, $respLaboratorios)) { $data461 = 'checked=""'; } else { $data461 = ''; }
        if (in_array(462, $respLaboratorios)) { $data462 = 'checked=""'; } else { $data462 = ''; }
        if (in_array(463, $respLaboratorios)) { $data463 = 'checked=""'; } else { $data463 = ''; }
        if (in_array(464, $respLaboratorios)) { $data464 = 'checked=""'; } else { $data464 = ''; }
        if (in_array(465, $respLaboratorios)) { $data465 = 'checked=""'; } else { $data465 = ''; }
        if (in_array(466, $respLaboratorios)) { $data466 = 'checked=""'; } else { $data466 = ''; }
        if (in_array(467, $respLaboratorios)) { $data467 = 'checked=""'; } else { $data467 = ''; }
        if (in_array(468, $respLaboratorios)) { $data468 = 'checked=""'; } else { $data468 = ''; }
        if (in_array(469, $respLaboratorios)) { $data469 = 'checked=""'; } else { $data469 = ''; }
        if (in_array(470, $respLaboratorios)) { $data470 = 'checked=""'; } else { $data470 = ''; }
        if (in_array(471, $respLaboratorios)) { $data471 = 'checked=""'; } else { $data471 = ''; }
        if (in_array(472, $respLaboratorios)) { $data472 = 'checked=""'; } else { $data472 = ''; }
        if (in_array(473, $respLaboratorios)) { $data473 = 'checked=""'; } else { $data473 = ''; }
        if (in_array(474, $respLaboratorios)) { $data474 = 'checked=""'; } else { $data474 = ''; }
        if (in_array(475, $respLaboratorios)) { $data475 = 'checked=""'; } else { $data475 = ''; }
        if (in_array(476, $respLaboratorios)) { $data476 = 'checked=""'; } else { $data476 = ''; }
        if (in_array(477, $respLaboratorios)) { $data477 = 'checked=""'; } else { $data477 = ''; }
        if (in_array(478, $respLaboratorios)) { $data478 = 'checked=""'; } else { $data478 = ''; }
        if (in_array(479, $respLaboratorios)) { $data479 = 'checked=""'; } else { $data479 = ''; }
        if (in_array(480, $respLaboratorios)) { $data480 = 'checked=""'; } else { $data480 = ''; }
        if (in_array(481, $respLaboratorios)) { $data481 = 'checked=""'; } else { $data481 = ''; }
        if (in_array(482, $respLaboratorios)) { $data482 = 'checked=""'; } else { $data482 = ''; }
        if (in_array(483, $respLaboratorios)) { $data483 = 'checked=""'; } else { $data483 = ''; }
        if (in_array(484, $respLaboratorios)) { $data484 = 'checked=""'; } else { $data484 = ''; }
        if (in_array(485, $respLaboratorios)) { $data485 = 'checked=""'; } else { $data485 = ''; }
        if (in_array(486, $respLaboratorios)) { $data486 = 'checked=""'; } else { $data486 = ''; }
        if (in_array(487, $respLaboratorios)) { $data487 = 'checked=""'; } else { $data487 = ''; }
        if (in_array(488, $respLaboratorios)) { $data488 = 'checked=""'; } else { $data488 = ''; }
        if (in_array(489, $respLaboratorios)) { $data489 = 'checked=""'; } else { $data489 = ''; }
        if (in_array(490, $respLaboratorios)) { $data490 = 'checked=""'; } else { $data490 = ''; }
        if (in_array(491, $respLaboratorios)) { $data491 = 'checked=""'; } else { $data491 = ''; }
        if (in_array(492, $respLaboratorios)) { $data492 = 'checked=""'; } else { $data492 = ''; }
        if (in_array(493, $respLaboratorios)) { $data493 = 'checked=""'; } else { $data493 = ''; }
        if (in_array(494, $respLaboratorios)) { $data494 = 'checked=""'; } else { $data494 = ''; }
        if (in_array(495, $respLaboratorios)) { $data495 = 'checked=""'; } else { $data495 = ''; }
        if (in_array(496, $respLaboratorios)) { $data496 = 'checked=""'; } else { $data496 = ''; }
        if (in_array(497, $respLaboratorios)) { $data497 = 'checked=""'; } else { $data497 = ''; }
        if (in_array(498, $respLaboratorios)) { $data498 = 'checked=""'; } else { $data498 = ''; }
        if (in_array(499, $respLaboratorios)) { $data499 = 'checked=""'; } else { $data499 = ''; }
        if (in_array(500, $respLaboratorios)) { $data500 = 'checked=""'; } else { $data500 = ''; }
        if (in_array(501, $respLaboratorios)) { $data501 = 'checked=""'; } else { $data501 = ''; }
        if (in_array(502, $respLaboratorios)) { $data502 = 'checked=""'; } else { $data502 = ''; }
        if (in_array(503, $respLaboratorios)) { $data503 = 'checked=""'; } else { $data503 = ''; }
        if (in_array(504, $respLaboratorios)) { $data504 = 'checked=""'; } else { $data504 = ''; }
        if (in_array(505, $respLaboratorios)) { $data505 = 'checked=""'; } else { $data505 = ''; }
        if (in_array(506, $respLaboratorios)) { $data506 = 'checked=""'; } else { $data506 = ''; }


        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A5',
            'default_font_size' => 9,
            'default_font' => 'sans-serif',
            'margin_left' => 6,
            'margin_right' => 6,
            'margin_top' => 6,
            'margin_bottom' => 3
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
        if(count($tomografias) > 0){
            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 14px;" class="titulo">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="40" width="40"></td>');
            $mpdf->WriteHTML('<td style="width:80%"><b>DR. PERCY MALDONADO M. - MEDICINA INTERNA</b></td>');
            $mpdf->WriteHTML('<td style="width:10%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<h3 class="subtitulo">ORDEN DE TOMOGRAFÍAS</h3>');
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
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data1 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data2 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Cadera + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data41 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data42 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Hipófisis</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data3 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data4 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Fémur + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data43 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data44 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Senos Paranasales</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data5 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data6 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Rodilla + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data45 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data46 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Macizo Facial</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data7 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data8 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Pierna + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data47 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data48 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Órbitas</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data9 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data10 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Tobillos + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data49 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data50 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Oídos</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data11 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data12 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Pie + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data51 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data52 .'/></td>');
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
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data13 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data14 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Columna Lumbar + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data53 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data54 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Abdomen Inferior</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data15 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data16 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Columna Dorsal + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data55 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data56 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Abdomen Total</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data17 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data18 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Columna Cervical + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data57 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data58 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Hepático</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data19 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data20 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Sacroxocigea + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data59 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data60 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Pelvis</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data21 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data22 .'/></td>');
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
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data23 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data24 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Cuello</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data61 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data62 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM (Tórax / HD)</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data25 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data26 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Tiroideas</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data63 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data64 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Mediastino</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data27 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data28 .'/></td>');
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
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data29 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data30 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Pulmonar</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data65 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data66 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Húmero + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data31 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data32 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Abdominal</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data67 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data68 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Codo + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data33 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data34 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Miembros Superiores</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data69 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data70 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Antebrazo + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data35 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data36 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Miembros Inferiores</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data71 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data72 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Muñeca + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data37 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data38 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Carótida</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data73 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data74 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:39%">TEM Mano + 3D</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data39 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data40 .'/></td>');
            $mpdf->WriteHTML('<td style="width:2%"></td>');
            $mpdf->WriteHTML('<td style="width:39%">Angio TEM Cerebral</td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data75 .'/></td>');
            $mpdf->WriteHTML('<td style="width:5%; text-align: center"><input type="radio" id="huey" name="drone" value="huey" '. $data76 .'/></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');
        }

        if(count($ecografias)){
            $mpdf->AddPage();

            //CUERPO HTML-------------------------------------------------------------------------------
            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 14px;" class="titulo">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="40" width="40"></td>');
            $mpdf->WriteHTML('<td style="width:80%"><b>DR. PERCY MALDONADO M. - MEDICINA INTERNA</b></td>');
            $mpdf->WriteHTML('<td style="width:10%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<h3 class="subtitulo">ORDEN DE ECOGRAFÍAS</h3>');
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
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data77 .'/> ECO Abdomen Completo</td>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data78 .'/> ECO Abdomen Superior</td>');
            $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" '. $data79 .'/> ECO Abdomen Inferior</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data80 .'/> ECO Cadera</td>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data81 .'/> ECO Cerebral Transfontanelar</td>');
            $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" '. $data82 .'/> ECO Hombro</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data83 .'/> ECO Mama</td>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data92 .'/> ECO Vesical</td>');
            $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" '. $data85 .'/> ECO Pared Toráxica y Pleuras</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data86 .'/> ECO Partes Blandas</td>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data87 .'/> ECO Pélvica</td>');
            $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" '. $data88 .'/> ECO Próstata y Vejiga</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data89 .'/> ECO Renal Vesical</td>');
            $mpdf->WriteHTML('<td style="width:33%"><input type="radio" id="huey" name="drone" value="huey" '. $data90 .'/> ECO Rodilla</td>');
            $mpdf->WriteHTML('<td style="width:34%"><input type="radio" id="huey" name="drone" value="huey" '. $data91 .'/> ECO Testicular</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:33%" colspan="3"><input type="radio" id="huey" name="drone" value="huey" '. $data84 .'/> ECO Músculo Esquelético (codo, muñeca, tobillo)</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<br>');

            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:100%; text-align: center" class="subtitulo2" colspan="2">ECOGRAFÍAS GINECO OBSTÉTRICAS</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data94 .'/> ECO Doppler Obstétrica</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data95 .'/> ECO Doppler Fetal</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data104 .'/> ECO Transvaginal</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data96 .'/> Ecografía 4D</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data97 .'/> ECO Genética</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data98 .'/> ECO Mamaria</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data99 .'/> ECO Monitoreo de Ovulación (por sesión)</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data100 .'/> ECO Morfológica</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data101 .'/> ECO Obstétrica</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data102 .'/> ECO Pélvica Transvesical</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data103 .'/> ECO Perfil Biofísico Fetal</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data93 .'/> ECO Doppler de Ovarios, Útero y Anexos (transvaginal)</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<br>');

            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:100%; text-align: center" class="subtitulo2" colspan="2">ECOGRAFÍAS </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data105 .'/> ECO Doppler Arterial - Miembros Superiores</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data106 .'/> ECO Doppler Arterial - Miembros Inferiores</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data107 .'/> ECO Doppler Carotideo y Vertebral</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data108 .'/> ECO Doppler de Mamas</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data109 .'/> ECO Doppler del Sistema Porta</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data110 .'/> ECO Doppler Esplénico</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data111 .'/> ECO Doppler Mamaria</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data112 .'/> ECO Doppler Pélvica</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data113 .'/> ECO Doppler Renal</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data114 .'/> ECO Doppler Testicular</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data115 .'/> ECO Doppler Tiroides</td>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data116 .'/> ECO Doppler Venosos - Miembros Superiores</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:50%"><input type="radio" id="huey" name="drone" value="huey" '. $data117 .'/> ECO Doppler Venosos - Miembros Inferiores</td>');
            $mpdf->WriteHTML('<td style="width:50%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');
        }

        if(count($radiografias)){
            $mpdf->AddPage();

            //CUERPO HTML-------------------------------------------------------------------------------
            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 14px;" class="titulo">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="40" width="40"></td>');
            $mpdf->WriteHTML('<td style="width:80%"><b>DR. PERCY MALDONADO M. - MEDICINA INTERNA</b></td>');
            $mpdf->WriteHTML('<td style="width:10%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<h3 class="subtitulo">ORDEN DE RADIOGRAFÍAS</h3>');
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
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data118 .'/> Agujero Óptico F/P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data144 .'/> Articulación C1-C2</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data173 .'/> Antebrazo F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data119 .'/> Arco Cigomático</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data145 .'/> Articulación coxofemoral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data174 .'/> Brazo - Húmero</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data120 .'/> Articulación Témporo Maxilar</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data146 .'/> Articulación sacroiliaca bilateral F-20B</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data175 .'/> Calcáneo Corporativo</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data121 .'/> Articulación Témporo Maxilar Bilateral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data147 .'/> Articulación sacroiliaca Unilateral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data176 .'/> Calcáneo F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data122 .'/> Cavum</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data148 .'/> Cadera coxofemoral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data177 .'/> Codo F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data123 .'/> Cráneo frontal y perfil</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data149 .'/> Cadera Lowestein</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data178 .'/> Edad Osea</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data124 .'/> Huesos propios de la nariz F/P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data150 .'/> Cadera Van Rossen</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data179 .'/> Fémur</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data125 .'/> Mastoides</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data151 .'/> Columna cervical F-P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data180 .'/> Hombro</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data126 .'/> Maxilar superior</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data152 .'/> Columna cervical F-P-O</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data181 .'/> Hombro Comparativo</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data127 .'/> Maxilar inferior</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data153 .'/> Columna cervical Funcional</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data182 .'/> Hombro funcional unilateral</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data128 .'/> Órbitas</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data154 .'/> Columna cervical dorsal</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data183 .'/> Hombro funcional bilateral</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data129 .'/> Peñasco cada lado</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data155 .'/> Columna dorsal F-P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data184 .'/> Mano F-O</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data130 .'/> Senos paranasales</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data156 .'/> Columna dorsal F-P-O</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data185 .'/> Mano F-Lateral</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data131 .'/> Silla Turca frontal y perfil</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data157 .'/> Columna dorsal funcional</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data186 .'/> Medición de miembros</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX TÓRAX</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data158 .'/> Columna dorso lumbar</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data187 .'/> Muñeca F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data132 .'/> Clavícula Bilateral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data159 .'/> Columna Lumbar</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data188 .'/> Panorámico de Miembros</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data133 .'/> Clavícula Unilateral</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data160 .'/> Columna Lumbo sacra F-P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data189 .'/> Pie</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data134 .'/> Corazón y grandes vasos</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data161 .'/> Columna Lumbo sacra F-P-O</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data190 .'/> Pierna F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data135 .'/> Esternón F-O</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data162 .'/> Columna Lumbo sacra Funcional</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data191 .'/> Pies Comparativos</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data136 .'/> Parrilla Costal F-O</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data163 .'/> Columna sacro coxigea F-P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data192 .'/> Rodilla F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data137 .'/> Tórax F</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data164 .'/> Columna Panorámica</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data193 .'/> Rótulo Bilateral</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data138 .'/> Tórax F-P</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data165 .'/> Pelvis</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data194 .'/> Rótula F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX APARATO UROGENITAL</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX APARATO DIGESTIVO</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data195 .'/> Survey Oseo</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data139 .'/> Cistografía</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data166 .'/> Abdomen simple</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data196 .'/> Tobillo comparativo</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data140 .'/> Histerosalpingografía</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data167 .'/> Abdomen simple de cúbito y pie</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data197 .'/> Tobillo F-P</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data141 .'/> Simple de aparato urinario</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data168 .'/> Colangiografía postoperatoria</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%; text-align: center" class="subtitulo2">RX OTROS</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data142 .'/> Uretografía Retrógrada</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data169 .'/> Colon doble contraste</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data198 .'/> Cuerpo Extraño</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data143 .'/> Urografía Excretoria</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data170 .'/> Esofagograma</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data199 .'/> Fistulografía</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"></td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data171 .'/> Esófago, estómago y duodeno contraste X2</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:32%"></td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"><input type="radio" id="huey" name="drone" value="huey" '. $data172 .'/> Intestino delgado</td>');
            $mpdf->WriteHTML('<td style="width:2%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:32%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');
        }

        if(count($laboratorios)){
            $mpdf->AddPage('L');

            //CUERPO HTML-------------------------------------------------------------------------------
            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 14px;" class="titulo">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="40" width="40"></td>');
            $mpdf->WriteHTML('<td style="width:80%"><b>DR. PERCY MALDONADO M. - MEDICINA INTERNA</b></td>');
            $mpdf->WriteHTML('<td style="width:10%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->WriteHTML('<h3 class="subtitulo">ORDEN DE LABORATORIO CLÍNICO</h3>');
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

            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 6px">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">BIOQUIMICA</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">MICROBIOLOGIA</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">INMUNOLOGIA</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">HEMATOLOGIA</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%; text-align: center" class="subtitulo2">ORINA</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data200 .'/> Ácido Úrico</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data229 .'/> BK Directo X1</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data257 .'/> Aglutinaciones en lámina</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data279 .'/> Constantes Corpusculares</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data300 .'/> Depuracion de creatinina</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data201 .'/> Amilasa</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data230 .'/> BK Directo X2</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data258 .'/> Anti Estreptolisina - ASO</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data280 .'/> Ferritina</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data301 .'/> Examen completo de orina</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data202 .'/> Bilirrubinas Totales y Fraccionadas</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data231 .'/> BK Directo X3</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data259 .'/> Beta HCG Cualitativo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data281 .'/> Fibrinógeno</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data302 .'/> Microalbuminuria 24 hrs</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data203 .'/> BUN Ureico</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data232 .'/> Coprocultivo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data260 .'/> Beta HCG Cuantitativo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data282 .'/> Gota gruesa para paludismo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data303 .'/> Microalbuminuria en orina simple</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data204 .'/> Calcio Ionico</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data233 .'/> Cultivo de BK</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data261 .'/> COOMBS Directo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data283 .'/> Grupo sanguineo y RH</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data304 .'/> Proteina en orina simple</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data205 .'/> Calcio Serico</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data234 .'/> Cultivo de Hongos</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data262 .'/> COOMBS Indirecto</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data284 .'/> Hematocrito y hemoglobina</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data305 .'/> Proteinuria Cualitativa</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data206 .'/> Colesterol HDL</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data235 .'/> Cultivo de secrecion conjuntival</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data263 .'/> Factor Reumatoideo semicuantitativo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data285 .'/> Hemograma automatizado</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data306 .'/> Proteinuria de 24 hrs</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data207 .'/> Colesterol LDL</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data236 .'/> Cultivo de secrecion faringe</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data264 .'/> Hepatitis A IGM</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data286 .'/> Recuento de plaquetas</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%; text-align: center" class="subtitulo2">HECES</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data208 .'/> Colesterol Total</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data237 .'/> Cultivo de secrecion</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data265 .'/> Hepatitis B Antígeno Australiano</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data287 .'/> Reticulocitos</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data307 .'/> Coloracion Vago (Campylobacter)</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data209 .'/> CPK-MB</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data238 .'/> Cultivo de semen</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data266 .'/> Inmunoglobulina E</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data288 .'/> Tiempo de coagulacion</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data308 .'/> Coprologico funcional</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data210 .'/> Creatinina</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data239 .'/> GRAM</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data267 .'/> PCR Cuantitativo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data289 .'/> Tiempo de sangría</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data309 .'/> Parasitologico X1</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data211 .'/> Creatininfosfoquinasa (EPK Total)</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data240 .'/> KOH (Hongos)</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data268 .'/> PCR Ládex</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data290 .'/> TPTA</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data310 .'/> Parasitologico X2</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data212 .'/> Deshidrogenasa Láctica (DHL)</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data241 .'/> Urocultivo</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data269 .'/> RPR</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data291 .'/> TP / INR</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data311 .'/> Parasitologico X3</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data213 .'/> Electrolitos Sérico (Na, Cl, K, Ca) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">HORMONAS</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data270 .'/> Troponina I </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data292 .'/> Velocidad de sedimentacion </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data312 .'/> Reacción inflamatoria </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data214 .'/> Fosfatasa Alcalina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data242 .'/> Cortisol AM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data271 .'/> VIH </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">PERFILES</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data313 .'/> Test de Graham </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data215 .'/> Fósforo </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data243 .'/> Cortisol PM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">MARCADORES TUMORALES</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data293 .'/> Perfil cardiaco </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data314 .'/> Thevenom (sangre oculta) </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data216 .'/> Gamma-Glutamil Transpeptidasa </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data244 .'/> Estradiol </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data272 .'/> AFP (Hígado) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data294 .'/> Perfil de coagulacion </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%; text-align: center" class="subtitulo2">MARCADORES CARDIACOS</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data217 .'/> Glucosa Basal </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data245 .'/> FHS </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data273 .'/> CA 19-9 (páncreas) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data295 .'/> Perfil hepático </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data315 .'/> CPK MB </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data218 .'/> Glucosa Postprandial </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data246 .'/> Insulina basal </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data274 .'/> CA-125 (Ovario) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data296 .'/> Perfil lipídico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data316 .'/> CPK TOTAL </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data219 .'/> Hemoglobina Glicosilada </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data247 .'/> Insulina Postprandial </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data275 .'/> CEA (colon) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data297 .'/> Perfil Pre-QX </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data317 .'/> Troponina I </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data220 .'/> Hierro Sérico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data248 .'/> LH </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data276 .'/> PSA Índice (panel completo) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data298 .'/> Perfil tiroideo </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data221 .'/> Lipasa Sérico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data249 .'/> Progesterona </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data277 .'/> PSA LIBRE </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data299 .'/> Perfil del recien nacido </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data222 .'/> Magnesio </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data250 .'/> Prolactina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data278 .'/> PSA TOTAL </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data223 .'/> Proteinas totales fraccionadas </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data251 .'/> T3 Libre </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data224 .'/> Tolerancia a la glucosa </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data252 .'/> T3 Total </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data225 .'/> Transaminasa Oxalacética (TGO/AST) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data253 .'/> T4 Libre </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data226 .'/> Transaminasa Pirúvica (TGP/ALT) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data254 .'/> T4 Total </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data227 .'/> Triglicéridos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data255 .'/> Testosterona total </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data228 .'/> Úrea </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data256 .'/> TSH </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

            $mpdf->AddPage('L');

            $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 6px">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%; text-align: center" class="subtitulo2">ESPECIALES</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data355 .'/> Beta 2 Microglobulina (Orina simple) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data394 .'/> Crioglobulinas - Sérocas </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data434 .'/> Hepatitis delta </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data473 .'/> Rubeola - Anticuerpos IGM </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data318 .'/> 17 Cetoesteroide </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data356 .'/> BK PCR </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data395 .'/> Cryptococcus LCR - Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data435 .'/> Hepatitis - Hbe AC - Anticuerpos contra ANTE </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data474 .'/> Sífilis (Elisa) </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data319 .'/> 17 Hidroxicorticoide </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data357 .'/> Rosa de bengala </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data396 .'/> Cryptococcus LCR - Antígenos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data436 .'/> Herpes I - IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data475 .'/> Somatomedina C (IGF-1) </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data320 .'/> 17 Hidroxiprogesterona </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data358 .'/> CA-27.29 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data397 .'/> Cryptococcus Suero - Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data437 .'/> Herpes I - IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data476 .'/> SS-A Anticuerpos (Anti-RO) </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data321 .'/> Hidroxiindolacético </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data359 .'/> CA-549 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data398 .'/> Cryptococcus Suero - Antígenos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data438 .'/> Herpes II - IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data477 .'/> SS-A Anticuerpos (Anti-LA) </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data322 .'/> A.P.A. (antipolímero anticuerpo) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data360 .'/> CA-72.4 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data399 .'/> Dengue virus anticuerpos IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data439 .'/> Herpes II - IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data478 .'/> Tincion Kinyoun </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data323 .'/> Acetil colina receptor-anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data361 .'/> Cadenas ligeras libre de suero </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data400 .'/> Dengue virus anticuerpos IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data440 .'/> Hidatidosis - Anticuerpo (Elisa) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data479 .'/> TORCH IGG </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data324 .'/> Acetilcolinesterasa-anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data362 .'/> Calcitonina - Dosaje </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data401 .'/> DHEA SO4 (Dehidroepiandrosterona) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data441 .'/> Hidatidosis - Western Blot </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data480 .'/> TORCH IGM </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data325 .'/> Ácido valproico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data363 .'/> Candida Albicans anticuerpos IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data402 .'/> Difenil Hidantoina - Libre (L1) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data442 .'/> HIV Western Blot </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data481 .'/> Toxoplasma Gondi IGG </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data326 .'/> Ácido vanilmandelico (orina 24hrs) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data364 .'/> Carbamazepina (CBZ) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data403 .'/> Dihidrotestosterona </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data443 .'/> HLA B-27 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data482 .'/> Toxoplasma Gondi IGM </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data327 .'/> Ácidos biliares </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data365 .'/> Cardiolipina - Anticuerpos IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data404 .'/> DNA Cadena Simple - Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data444 .'/> Homocisteina Sérica </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data483 .'/> Transglutaminasa </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data328 .'/> ACTH (AM Basal) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data366 .'/> Cardiolipina - Anticuerpos IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data405 .'/> Factor VIII </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data445 .'/> Hormona Del Crecimiento </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data484 .'/> Autoanticuerpos IGA </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data329 .'/> Aldolasa </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data367 .'/> HIV-1 Carga viral ARN X PCR </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data406 .'/> Factor IX </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data446 .'/> Horm. Crec. Postestimulación </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data485 .'/> Troponina T </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data330 .'/> ANA-Anticuerpos antinucleares </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data368 .'/> Caroteno sérico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data407 .'/> Electroforesis Hemoglobina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data447 .'/> Horm. Anti Mulleriana (AMH/MIS) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data486 .'/> TSI Estimulante De Tiroides </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data331 .'/> ANCA Anti-neutrófilos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data369 .'/> Centrómero-Autoanticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data408 .'/> Electrolitos Orina 24 Hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data448 .'/> HTLV I Y II Anticuerpos (Elisa) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data487 .'/> Varicela Zóster IGG </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data332 .'/> Androstenediona </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data370 .'/> Ceruloplasmina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data409 .'/> Elestasa Fecal </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data449 .'/> HTLV I Y II Western Blot </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data488 .'/> Varicela Zóster IGM </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data333 .'/> Anti-histona </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data371 .'/> Ch50 complemento </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data410 .'/> ENA - Perfil Autoinmune (IM) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data450 .'/> Saturación De Transferrina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data489 .'/> VIH P24 </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data334 .'/> Anti CCP IGG (péptido cíclico citruliano) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data372 .'/> Chagas-tripanozona-cruzi </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data411 .'/> Endomisio - Autoantic. (EMA) (L5) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data451 .'/> Inhibina B </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data490 .'/> Vitamina B1 </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data335 .'/> Anti Mitocondriales (AMA) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data373 .'/> Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data412 .'/> NSE-Enolasa Neurono-Específica (L6) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data452 .'/> Inmunoglobulina A </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data491 .'/> Vitamina B12 </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data336 .'/> Anti músculo liso (ASMA) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data374 .'/> Chlamydia Pneumoniae IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data413 .'/> Epstein Bar Virus (EBNA IGM) (L5) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data453 .'/> Inmunoglobulina G </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data492 .'/> Vitamina B6 </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data337 .'/> Anti RNP </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data375 .'/> Chlamydia Pneumoniae IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data414 .'/> Epstein Bar Virus (EBNA IGG) (L5) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data454 .'/> Inmunoglobulina M </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data493 .'/> Vitamina D </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data338 .'/> Anti SCL 70 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data376 .'/> Chlamydia Psitaci, IGM Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data415 .'/> Eritropoyetina Sérica </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data455 .'/> Insulina - Antícuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%; text-align: center" class="subtitulo2"> ESPERMATOGRAMA </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data339 .'/> Anti SM Smith </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data377 .'/> Chlamydia Trachomatis IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data416 .'/> Factor Intrínseco - Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data456 .'/> Litio </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data494 .'/> LCR BK Directo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data340 .'/> Anticoagulante Lúpico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data378 .'/> Chlamydia Trachomatis IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data417 .'/> Factor V </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data457 .'/> Litio - Tasa Transporte </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data495 .'/> LCR Citoquímico </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data341 .'/> Anticuerpos Heterófilos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data379 .'/> Ciclosporina A(L6) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data418 .'/> Fenómeno LE (Células Le) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data458 .'/> Magnesio 24 Hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data496 .'/> LCR Cultivo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data342 .'/> Anti DNA DS (IM) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data380 .'/> Cyfra 21-1 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data419 .'/> Fósforo En Orina </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data459 .'/> Metanefrina En Orina 24 Hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data497 .'/> Líquido Ascítico BK Directo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data343 .'/> Anti DNA SS Auto Anticuerpo </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data381 .'/> Cisticercus Eia </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data420 .'/> Fósforo En Orina 24hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data460 .'/> Ntx Telopéptido </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data498 .'/> Líquido Ascítico Citoquímice </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data344 .'/> Anti - Espermatozoides </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data382 .'/> Cisticercus LCR (Western Blot) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data421 .'/> FTA - ABS IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data461 .'/> Osmolaridad Urinaria (Azar O 24 Hrs) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data499 .'/> Líquido Ascítico Cultivo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data345 .'/> Anti-Fosfolipidos IGG - IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data383 .'/> Cisticercus (Western Blot) Suero </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data422 .'/> FTA - ABS En L.C.R </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data462 .'/> Panel De Alergia (34 Alergenos) Ige Esp. </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data500 .'/> Líquido Pleural Bk Directo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data346 .'/> Anti-Liverkdney Microsomales </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data384 .'/> Citomegalovirus IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data423 .'/> Gliadina - Anticuerpos </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data463 .'/> Paperas IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data501 .'/> Líquido Plerual Citoquímico </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data347 .'/> Antitrombina III Dosaje </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data385 .'/> Citomegalovirus IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data424 .'/> Glucagon </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data464 .'/> Paperas IGM</td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data502 .'/> Líquido Plerual Cultivo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data348 .'/> Bandas Oligocionales (LRC) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data386 .'/> Citrato En Orina De 24hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data425 .'/> Glucosa 6 - Fosfato Dehidrogenasa </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data465 .'/> Paratohormona Intacta (Pth-Intacta) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data503 .'/> Líquido Plerual Cultivo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data349 .'/> Bartonella Henselae IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data387 .'/> Clonazepam (Rivotril) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data426 .'/> Helicobacter Pilori IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data466 .'/> Péptido C </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data504 .'/> Líquido Sinovial BK Directo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data350 .'/> Bartonella Henselae IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data388 .'/> Cobre En Orina 24hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data427 .'/> Helicobacter Pilori IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data467 .'/> Péptido C 120 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data505 .'/> Líquido Sinovial Citoquimio </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data351 .'/> Beta 2 Glicoproteína IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data389 .'/> Cobre Sérico </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data428 .'/> Hepatitis A Anticuerpos IGG </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data468 .'/> Procalcitonina - PCT </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"><input type="radio" id="huey" name="drone" value="huey" '. $data506 .'/> Líquido Sinovial Cultivo </td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data352 .'/> Beta 2 Glicoproteina IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data390 .'/> Complemento C2 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data429 .'/> Hepatitis A Anticuerpos IGM </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data469 .'/> Proeína C Funcional </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data353 .'/> Beta 2 Microglobulina (Orina 24 Hrs) </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data391 .'/> Complemento C3 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data430 .'/> Hepatitis B Carga Viral </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data470 .'/> Proeína S Funcional </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data354 .'/> Beta 2 Microglobulina Sérica </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data392 .'/> Complemento C4 </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data431 .'/> Hepatitis C - HCV PCR </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data471 .'/> Proteinograma Electroforético </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data393 .'/> Cortisol En Orina 24hrs </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data432 .'/> Hepatitis C Carga Viral </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data472 .'/> Rose Waaler </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"><input type="radio" id="huey" name="drone" value="huey" '. $data433 .'/> Hepatitis C Genotipificación </td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:19%"></td>');
            $mpdf->WriteHTML('<td style="width:1%; text-align: center"></td>');
            $mpdf->WriteHTML('<td style="width:20%"></td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('</table>');

        }

        if(count($tomografias) + count($ecografias) + count($radiografias) + count($laboratorios) > 0){
            return $mpdf->Output('procedimientos.pdf', 'I');
        }

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
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 14px;" class="titulo">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="40" width="40"></td>');
        $mpdf->WriteHTML('<td style="width:80%"><b>DR. PERCY MALDONADO M. - MEDICINA INTERNA</b></td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<h3 class="subtitulo">RECETA MÉDICA</h3>');
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%" class="subtitulo2">PACIENTE</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:100%">'. $person->number . ' - ' . $person->name .'</td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">DIANÓSTICOS</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 10px">');
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
            $mpdf->WriteHTML('<td style="width:100%; text-align: center" colspan="3">Sin Diagnósticos</td>');
            $mpdf->WriteHTML('</tr>');
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->WriteHTML('<br>');
        $mpdf->WriteHTML('<h3 class="subtitulo">MEDICAMENTOS</h3>');

        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; fontsize: 7px;">');

        if(count($medicamentos) > 0){
            foreach($medicamentos as $medicamento){
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:70%" class="subtitulo2">NOMBRE DEL MEDICAMENTO</td>');
            $mpdf->WriteHTML('<td style="width:30%" class="subtitulo2">FORMA</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:70%">'. $medicamento->medicine .'</td>');
            $mpdf->WriteHTML('<td style="width:30%">'. $medicamento->shape .'</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:70%" class="subtitulo2">DOSIS</td>');
            $mpdf->WriteHTML('<td style="width:30%" class="subtitulo2">CANT.</td>');
            $mpdf->WriteHTML('</tr>');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="width:70%">'. $medicamento->dose .'</td>');
            $mpdf->WriteHTML('<td style="width:30%">'. $medicamento->quantity .'</td>');
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
        $mpdf->WriteHTML('<table cellspacing="0" style="width: 100%; font-size: 16px;" class="titulo">');
        $mpdf->WriteHTML('<tr>');
        $mpdf->WriteHTML('<td style="width:10%"><img src="dist/img/logo.png" style="padding-bottom: 0px" height="60" width="60"></td>');
        $mpdf->WriteHTML('<td style="width:80%"><b>HISTORIA CLINICA - CONSULTA EXTERNA</b></td>');
        $mpdf->WriteHTML('<td style="width:10%"></td>');
        $mpdf->WriteHTML('</tr>');
        $mpdf->WriteHTML('</table>');

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

    public function edit($id)
    {
        $history = MedicalRecords::find($id);
        $personHistory = PersonHistory::where('person_id', '=', $history->person_id)->first();
        $person = Persons::find($history->person_id);
        $person->age = Carbon::parse($person->birthdate)->age;

        return view('edit_history', compact('history', 'person', 'personHistory'));
    }

    public function update(Request $request, $id)
    {
        dd($request);
    }

    public function destroy(MedicalRecords $medicalRecords)
    {
        //
    }
}
