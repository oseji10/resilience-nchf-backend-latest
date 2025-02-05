<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulting;
use App\Models\Encounters;
use App\Models\ContinueConsulting;
class ContinueConsultingController extends Controller
{
    public function RetrieveAll()
    {
        $continue_consulting = ContinueConsulting::with('encounters', 'patients')->get();
        return response()->json($continue_consulting); 
       
    }

    public function store(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();
    
        // Create a new ContinueConsulting record
        $continue_consulting = ContinueConsulting::create($data);
    
        // Find the Encounter by the encounterId sent in the request
        $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
        if ($encounter) {
            // Update the Encounter with the continueConsultingId
            $encounter->update([
                'continueConsultingId' => $continue_consulting->continueConsultingId, // Assuming id is the primary key of ContinueConsulting
            ]);
    
      
        }
    
        return response()->json(['encounterId' =>$encounter->encounterId], 201);// HTTP status code 201: Created
    }
    
    
}
