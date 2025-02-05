<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulting;
use App\Models\Encounters;
use App\Models\Refraction;
class RefractionController extends Controller
{
    public function RetrieveAll()
    {
        $refraction = Refraction::with('encounters', 'patients')->get();
        return response()->json($refraction); 
       
    }

    public function store(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();
    
        // Create a new ContinueConsulting record
        $refraction = Refraction::create($data);
    
        // Find the Encounter by the encounterId sent in the request
        $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
        if ($encounter) {
            // Update the Encounter with the continueConsultingId
            $encounter->update([
                'refractionId' => $refraction->refractionId, // Assuming id is the primary key of ContinueConsulting
            ]);
    
            // // Return a success response
            // return response()->json([
            //     'message' => 'ContinueConsulting record created and Encounter updated successfully.',
            //     'continueConsulting' => $continue_consulting,
            //     'encounter' => $encounter,
            // ], 201); // HTTP status code 201: Created
        }
    
        return response()->json(['encounterId' =>$encounter->encounterId], 201);// HTTP status code 201: Created
    }
    
    
}
