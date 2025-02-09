<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorAssessment;

class DoctorAssementController extends Controller
{
    public function RetrieveAll()
    {
        $doctorassessment = DoctorAssessment::all();
        return response()->json($doctorassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $doctorassessment = DoctorAssessment::create($data);
    
       
        return response()->json($doctorassessment, 201); 
    }
}
