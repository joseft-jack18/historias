<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Persons;
use App\Models\Countries;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Models\PersonHistory;
use App\Models\CatIdentityDocumentTypes;

class PersonsController extends Controller
{
    public function index()
    {
        $datos = Persons::paginate(10);

        // Formatear las fechas para mostrarlas como edad
        $datos->transform(function ($dato) {
            $dato->age = Carbon::parse($dato->birthdate)->age;
            return $dato;
        });

        return view('welcome', compact('datos'));
    }

    public function create()
    {
        $document_types = CatIdentityDocumentTypes::all();
        $countries = Countries::all();
        //$departments = Departments::all();

        return view('create_person', compact('document_types', 'countries'));
    }

    public function store(Request $request)
    {
        $person = new Persons();
        $person->type = $request->post('type');
        $person->identity_document_type_id = $request->post('identity_document_type_id');
        $person->number = $request->post('number');
        $person->name = $request->post('name');
        $person->trade_name = $request->post('name');
        $person->country_id = $request->post('country_id');
        $person->birthdate = $request->post('birthdate');
        $person->address = $request->post('address');
        $person->email = $request->post('email');
        $person->telephone = $request->post('telephone');
        $person->save();

        $id = $person->id;

        $histori = new PersonHistory();
        $histori->person_id = $id;
        $histori->personal_history = '';
        $histori->allergies_history = '';
        $histori->family_history = '';
        $histori->save();

        return redirect()->route('persons.index')->with('success','Agregado con éxito');
    }

    public function show(Persons $persons)
    {
        //
    }

    public function edit($id)
    {
        $person = Persons::find($id);
        $document_types = CatIdentityDocumentTypes::all();
        $countries = Countries::all();

        return view('edit_person', compact('person', 'document_types', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $person = Persons::find($id);

        $person->identity_document_type_id = $request->post('identity_document_type_id');
        $person->number = $request->post('number');
        $person->name = $request->post('name');
        $person->trade_name = $request->post('name');
        $person->country_id = $request->post('country_id');
        $person->birthdate = $request->post('birthdate');
        $person->address = $request->post('address');
        $person->email = $request->post('email');
        $person->telephone = $request->post('telephone');
        $person->save();

        return redirect()->route('persons.index')->with('success','Editado con éxito');
    }

    public function destroy(Persons $persons)
    {
        //
    }
}
