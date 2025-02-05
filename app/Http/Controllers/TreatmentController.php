<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Encounters;

class TreatmentController extends Controller
{
    public function saveTreatments(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'patientId' => 'nullable|string',
            'encounterId' => 'nullable|string',
            'eyeDrops' => 'nullable|array',
            'eyeDrops.*.medicine' => 'nullable|string',
            'eyeDrops.*.dosage' => 'nullable|string',
            'eyeDrops.*.doseDuration' => 'nullable|string',
            'eyeDrops.*.time' => 'nullable|string',
            'eyeDrops.*.doseInterval' => 'nullable|string',
            'eyeDrops.*.comment' => 'nullable|string',
            'tablets' => 'nullable|array',
            'tablets.*.medicine' => 'nullable|string',
            'tablets.*.dosage' => 'nullable|string',
            'tablets.*.doseDuration' => 'nullable|string',
            'tablets.*.time' => 'nullable|string',
            'tablets.*.doseInterval' => 'nullable|string',
            'tablets.*.comment' => 'nullable|string',
            'ointments' => 'nullable|array',
            'ointments.*.medicine' => 'nullable|string',
            'ointments.*.dosage' => 'nullable|string',
            'ointments.*.doseDuration' => 'nullable|string',
            'ointments.*.time' => 'nullable|string',
            'ointments.*.doseInterval' => 'nullable|string',
            'ointments.*.comment' => 'nullable|string',
            'prescriptionGlasses' => 'nullable|array',
            'prescriptionGlasses.*.frame' => 'nullable|string',
            'prescriptionGlasses.*.lensType' => 'nullable|string',
            'prescriptionGlasses.*.costOfLens' => 'nullable|numeric',
            'prescriptionGlasses.*.costOfFrame' => 'nullable|numeric',
        ]);

        $randomNumber = random_int(1000000000, 9999999999); // Generates a 10-digit random number
        // Initialize the prescriptions array
        $prescriptions = [];

        // Process eye drops, tablets, and ointments if they exist
        foreach (['eyeDrops', 'tablets', 'ointments', 'prescriptionGlasses'] as $type) {
            if (!empty($validatedData[$type])) { // Only process if the array is not empty
                foreach ($validatedData[$type] as $item) {
                    $prescriptions[] = [
                        'treatmentId' => $randomNumber,
                        'patientId' => $validatedData['patientId'] ?? null,
                        'encounterId' => $validatedData['encounterId'] ?? null,
                        'treatmentType' => $type ?? null,
                        'medicine' => $item['medicine'] ?? null,
                        'dosage' => $item['dosage'] ?? null,
                        'doseDuration' => $item['doseDuration'] ?? null,
                        'time' => $item['time'] ?? null,
                        'doseInterval' => $item['doseInterval'] ?? null,
                        'comment' => $item['comment'] ?? null,
                        'frame' => $item['frame'] ?? null,
'lensType' => $item['lensType'] ?? null,
'costOfLens' => $item['costOfLens'] ?? null,
'costOfFrame' => $item['costOfFrame'] ?? null,

                    ];
                }
            }
        }

   

        // Bulk insert if there are any prescriptions
        if (!empty($prescriptions)) {
           $treatment = Treatment::insert($prescriptions);
        }

        
        
        //    $treatmentId = Treatment::where('treatmentId', $randomNumber)->first();
           $encounter = Encounters::where('encounterId', $request->encounterId)->first();
    
           if ($encounter) {
               $encounter->update([
                   'treatmentId' => $randomNumber, // Use the generated sketchId
               ]);
           }
        return response()->json(['message' => 'Treatments saved successfully.'], 201);
    }
}
