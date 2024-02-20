<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Persons;
use App\Models\Procedures;
use Illuminate\Http\Request;
use App\Models\PersonHistory;
use App\Models\MedicalRecords;

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
        dd($request);

        //$datos = json_decode($request->datos);
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
