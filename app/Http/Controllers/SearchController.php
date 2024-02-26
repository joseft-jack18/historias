<?php

namespace App\Http\Controllers;

use App\Models\Diagnoses;
use App\Models\Medicines;
use App\Models\Procedures;
use App\Models\Specialties;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autocomplete_diagnosticos(Request $request)
    {
        $data = [];
        $term = $request->get('term');
        $querys = Diagnoses::where('description', 'like', '%'.$term.'%')
                    ->orWhere('internal_id', 'like', $term.'%')
                    ->limit(20)
                    ->get();

        foreach($querys as $query){
            $data[] = [
                'id' => $query->id,
                'label' => $query->internal_id.' - '.$query->description,
            ];
        }

        return $data;
    }

    public function autocomplete_interconsultas(Request $request)
    {
        $data = [];
        $term = $request->get('term');
        $querys = Specialties::where('description', 'like', '%'.$term.'%')
                    ->get();

        foreach($querys as $query){
            $data[] = [
                'id' => $query->id,
                'label' => $query->description,
            ];
        }

        return $data;
    }

    public function autocomplete_laboratorios(Request $request)
    {
        $data = [];
        $term = $request->get('term');
        $querys = Procedures::where('description', 'like', '%'.$term.'%')
                    ->where('specialty_id', '=', 2)
                    ->get();

        foreach($querys as $query){
            $data[] = [
                'id' => $query->id,
                'label' => $query->type." - ".$query->description,
            ];
        }

        return $data;
    }

    public function autocomplete_radiologicos(Request $request)
    {
        $data = [];
        $term = $request->get('term');
        $querys = Procedures::where('description', 'like', '%'.$term.'%')
                    ->where('specialty_id', '!=', 2)
                    ->get();

        foreach($querys as $query){
            $data[] = [
                'id' => $query->id,
                'label' => $query->type." - ".$query->description,
            ];
        }

        return $data;
    }

    public function autocomplete_medicamentos(Request $request)
    {
        $data = [];
        $term = $request->get('term');
        $querys = Medicines::where('description', 'like', '%'.$term.'%')
                    ->get();

        foreach($querys as $query){
            $data[] = [
                'label' => $query->description." - ".$query->brand,
            ];
        }

        return $data;
    }
}
