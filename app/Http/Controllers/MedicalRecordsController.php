<?php

namespace App\Http\Controllers;

use App\Models\MedicalDiagnoses;
use Carbon\Carbon;
use App\Models\Persons;
use App\Models\Procedures;
use Illuminate\Http\Request;
use App\Models\PersonHistory;
use App\Models\MedicalRecords;
use App\Models\MedicalTreatments;

class MedicalRecordsController extends Controller
{
    public function index($id)
    {
        $histories = MedicalRecords::where('person_id', $id)->get();

        return view('histories', compact('histories'));
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

        dd($presuntivos);
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
