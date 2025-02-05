<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Encounters;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    // Store Investigation Data
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patientId' => 'required|string',
            'encounterId' => 'required|string',
            'investigationsRequired' => 'nullable|string',
            'externalInvestigationsRequired' => 'nullable|string',
            'investigationsDone' => 'nullable|string',
            'HBP' => 'nullable|boolean',
            'diabetes' => 'nullable|boolean',
            'pregnancy' => 'nullable|boolean',
            'food' => 'nullable|string',
            'drugAllergy' => 'nullable|string',
            'currentMedication' => 'nullable|string',
        ]);
        $investigation = Investigation::create($validatedData);
        // return $investigation->investigationId;

        $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
        if ($encounter) {
            $encounter->update([
                'investigationId' => $investigation->investigationId, 
            ]);
    
        }
        return response()->json([
            'success' => true,
            'message' => 'Investigation saved successfully!',
            'data' => $investigation,
        ], 201);
    }
}
