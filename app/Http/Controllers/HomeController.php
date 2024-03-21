<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Persons;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
}
