<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CMDAssessment;

class CMDAssementController extends Controller
{
    public function RetrieveAll()
    {
        $cmdassessment = CMDAssessment::all();
        return response()->json($cmdassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $cmdassessment = CMDAssessment::create($data);
    
       
        return response()->json($cmdassessment, 201); 
    }
}
