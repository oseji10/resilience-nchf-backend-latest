<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyHistory;
class PatientFamilyHistoryController extends Controller
{
     public function RetrieveAll()
    {
        $familyhistory = FamilyHistory::all();
        return response()->json($familyhistoryassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $familyhistory = FamilyHistory::create($data);
    
       
        return response()->json($familyhistory, 201); 
    }
}
