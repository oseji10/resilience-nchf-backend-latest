<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalHistory;

class PatientPersonalHistoryController extends Controller
{
    public function RetrieveAll()
    {
        $personalhistory = PersonalHistory::all();
        return response()->json($personalhistoryassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $personalhistory = PersonalHistory::create($data);
    
       
        return response()->json($personalhistory, 201); 
    }
}
