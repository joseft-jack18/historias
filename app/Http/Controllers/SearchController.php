<?php

namespace App\Http\Controllers;

use App\Models\Diagnoses;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autocomplete_dp(Request $request)
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
}
