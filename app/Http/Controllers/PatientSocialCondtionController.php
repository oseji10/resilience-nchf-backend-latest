<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialCondition;
class PatientSocialCondtionController extends Controller
{
    public function RetrieveAll()
    {
        $socialcondition = SocialCondition::all();
        return response()->json($socialcondition);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $socialcondition = SocialCondition::create($data);
    
       
        return response()->json($socialcondition, 201); 
    }
}
