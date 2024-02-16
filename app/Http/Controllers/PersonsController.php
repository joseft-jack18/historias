<?php

namespace App\Http\Controllers;

use App\Models\Persons;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PersonsController extends Controller
{
    public function index()
    {
        $datos = Persons::all();

        // Formatear las fechas para mostrarlas como edad
        $datos->transform(function ($dato) {
            $dato->age = Carbon::parse($dato->birthdate)->age;
            return $dato;
        });

        return view('welcome', compact('datos'));
    }

    public function create()
    {
        return view('agregar');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Persons $persons)
    {
        //
    }

    public function edit(Persons $persons)
    {
        //
    }

    public function update(Request $request, Persons $persons)
    {
        //
    }

    public function destroy(Persons $persons)
    {
        //
    }
}
