<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\Manufacturers;
class MedicalHistoryController extends Controller
{
    public function RetrieveAll()
    {
        $medical_history = MedicalHistory::all();
        return response()->json($medical_history);
       
    }

    public function getOnePatientMedicalHistory($patientUserId)
    {
        $medical_history = MedicalHistory::where('patientUserId', $patientUserId)->first();
        return $medical_history;
       
    }
    

    public function store(Request $request)
    { 
        $data = $request->validate([
            'patientUserId' => 'required|integer',
            'hospitalId' => 'required|integer',
            'history' => 'required|string',
        ]);
        $data['addedBy'] = $request->user()->id; // Assuming you have authentication in place
        $medical_history = MedicalHistory::updateOrCreate(
            ['patientUserId' => $data['patientUserId']],
            $data
        );
    
        $statusCode = $medical_history->wasRecentlyCreated ? 201 : 200;
    
        return response()->json($medical_history, $statusCode);
    }


    public function update(Request $request, $medicalHistoryId)
    {
        // Find the medicine by ID
        $medical_history = MedicalHistory::find($medicalHistoryId);
        if (!$medical_history) {
            return response()->json([
                'error' => 'Medical History not found',
            ]); 
        }
    
        $data = $request->all();
        $medical_history->update($data);
        return response()->json([
            'message' => 'Medical History updated successfully',
            'data' => $medical_history,
        ], 200);
    }
    
    // Delete Drug
    public function deleteMedicalHistory($medicalHistoryId){
        $medical_history = MedicalHistory::find($medicalHistoryId);
    if ($medical_history) {
    $medical_history->delete();
    }
    return response()->json($medical_history, 201);
    }
    
}
