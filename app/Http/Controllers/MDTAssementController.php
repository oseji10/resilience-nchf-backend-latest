<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDTAssessment;

class MDTAssementController extends Controller
{
    public function RetrieveAll()
    {
        $mdtassessment = MDTAssessment::all();
        return response()->json($mdtassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $mdtassessment = MDTAssessment::create($data);
    
       
        return response()->json($mdtassessment, 201); 
    }
}
