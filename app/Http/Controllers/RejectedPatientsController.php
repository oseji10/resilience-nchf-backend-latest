<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RejectedPatients;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationReview;
use App\Models\Patient;
class RejectedPatientsController extends Controller
{
    public function index()
    {
        $rejected_patients = RejectedPatients::where('rejectedBy', Auth::id())->with('user.patient')->get();
        return response()->json($rejected_patients);
       
    }

    public function getOneRejectedPatients($patientUserId)
    {
        $rejected_patient = RejectedPatients::where('patientUserId', $patientUserId)->first();
        return $rejected_patient;
       
    }
    

    public function store(Request $request)
    { 
        $data = $request->validate([
            'patientUserId' => 'required|integer',
            'hospitalId' => 'required|integer',
            'reason' => 'required|string',
        ]);
        $patientUserId = $request->input('patientUserId');
        $data['rejectedBy'] = $request->user()->id; // Assuming you have authentication in place
        $rejected_patient = RejectedPatients::updateOrCreate(
            ['patientUserId' => $patientUserId],
            $data
        );

        $status_data['patientUserId'] = $patientUserId;
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 1;
        $status_data['statusId'] = 8;

        $application_status = ApplicationReview::create(
        $status_data
        );
    
        $patient_data = Patient::where('userId', '=', $patientUserId)->first();
        if (!$patient_data) {
            return response()->json([
                'error' => 'Patient data not found',
            ]); 
        }
    
        
        $patient_data->update(['status' => 8]);
    
    

        $statusCode = $rejected_patient->wasRecentlyCreated ? 201 : 200;
    
        return response()->json($rejected_patient, $statusCode);
    }


    public function update(Request $request, $medicalHistoryId)
    {
        // Find the medicine by ID
        $medical_history = RejectedPatients::find($medicalHistoryId);
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
        $medical_history = RejectedPatients::find($medicalHistoryId);
    if ($medical_history) {
    $medical_history->delete();
    }
    return response()->json($medical_history, 201);
    }
    
}
