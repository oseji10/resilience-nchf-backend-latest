<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NICRATAssementController extends Controller
{
    public function RetrieveAll()
    {
        $nicratassessment = NICRATAssessment::all();
        return response()->json($nicratassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $nicratassessment = NICRATAssessment::create($data);
    
       
        return response()->json($nicratassessment, 201); 
    }
}
