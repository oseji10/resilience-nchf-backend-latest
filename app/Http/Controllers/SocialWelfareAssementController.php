<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialWelfareAssessment;
class SocialWelfareAssementController extends Controller
{
    public function RetrieveAll()
    {
        $socialwelfareassessment = SocialWelfareAssessment::all();
        return response()->json($socialwelfareassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $socialwelfareassessment = SocialWelfareAssessment::create($data);
    
       
        return response()->json($socialwelfareassessment, 201); 
    }
}
