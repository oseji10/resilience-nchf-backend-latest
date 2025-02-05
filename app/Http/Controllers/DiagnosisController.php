<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulting;
use App\Models\Encounters;
use App\Models\Diagnosis;
class DiagnosisController extends Controller
{
    public function RetrieveAll()
    {
        $diagnosis = Diagnosis::with('encounters', 'patients')->get();
        return response()->json($diagnosis); 
       
    }

    public function store(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();
    
        // Create a new ContinueConsulting record
        $diagnosis = Diagnosis::create($data);
    
        
        $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
        if ($encounter) {
            $encounter->update([
                'diagnosisId' => $diagnosis->diagnosisId, // Assuming id is the primary key of ContinueConsulting
            ]);
    
        }
    
        return response()->json(['encounterId' =>$encounter->encounterId], 201);// HTTP status code 201: Created
    }
    
    
}
