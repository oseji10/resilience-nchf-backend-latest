<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulting;
use App\Models\Encounters;
class ConsultingController extends Controller
{
    public function RetrieveAll()
    {
        $consulting = Consulting::with('encounters', 'patients')->get();
        return response()->json($consulting); 
       
    }

    public function store(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();
    
        // Validate incoming request data (optional but recommended)
        // $validated = $request->validate([
        //     'patientId' => 'required|integer', // Example fields, adjust based on your schema
        //     'details' => 'nullable|string',    // Example field for consulting
        // ]);
    
        // Create a new consulting record
        $consulting = Consulting::create($data);
    
        // Create a new encounter record and link the consultingId
        $encounter = Encounters::create([
            'patientId' => $request->patientId,
            'consultingId' => $consulting->consultingId, // Link the consultingId
        ]);
    
        // Update the consulting record with the encounterId
        $consulting->update([
            'encounterId' => $encounter->encounterId, // Link the encounterId
        ]);
    
        // Return the newly created encounter and consulting as JSON response
        return response()->json(['encounterId' =>$encounter->encounterId], 201);// HTTP status code 201: Created
    }
    
}
