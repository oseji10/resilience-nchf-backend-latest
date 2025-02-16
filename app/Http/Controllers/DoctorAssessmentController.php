<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorAssessment;
use Illuminate\Support\Facades\Auth;
use App\Models\HospitalStaff;
use App\Models\Patient;
use App\Models\ApplicationReview;

class DoctorAssessmentController extends Controller
{
    public function RetrieveAll()
    {
        $doctorassessment = DoctorAssessment::all();
        return response()->json($doctorassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $doctorassessment = DoctorAssessment::create($data);
    
       
        return response()->json($doctorassessment, 201); 
    }


    
    public function doctorPatients(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::where('hospital', $hospitalId)
        ->where('doctor', $hospitalAdminId)
        // ->where('status', 3)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->whereHas('status', function ($query) {
        $query->where('statusId', 7); 
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details'
        
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }

    public function doctorReviewedPatients(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::where('hospital', $hospitalId)
        ->where('doctor', $hospitalAdminId)
        ->where('status', 3)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    // ->whereHas('status', function ($query) {
    //     $query->where('statusId', 3); 
    // })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details',
        'doctor_assessment',
        'social_welfare_assessment' ,
        'mdt_assessment',
        'cmd_assessment',
        'nicrat_assessment'
        
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }


    public function doctorPendingPatients(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::where('hospital', $hospitalId)
        ->where('doctor', $hospitalAdminId)
        ->where('status', 2)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    // ->whereHas('status', function ($query) {
    //     $query->where('statusId', 2); 
    // })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details' 
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }



    // DOCTOR CAREPLAN/ASSESSMENT
public function doctorcarePlan(Request $request)
{
    // Validate the request
    $request->validate([
        'patientId' => 'required',
        // 'reviewerId' => 'required',
        'carePlan' => 'required|string',
        'amountRecommended' => 'required|numeric',
        'status' => 'nullable', // Ensure it's either approved or disapproved
    ]);

    // Find the patient by ID
    $patient = Patient::findOrFail($request->patientId);

    // Prepare data for update
    $data = [
        'patientUserId' => $patient->userId,
        'reviewerId' => Auth::id(),
        'carePlan' => $request->carePlan,
        'amountRecommended' => $request->amountRecommended,
        'status' => 3, // Set approved or disapproved
    ];

    // Update patient record
    // $patient->update($data);
    DoctorAssessment::firstOrCreate($data);

    $status_data['patientUserId'] = $patient->userId;
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 2;
        $status_data['statusId'] = 3;

        $application_status = ApplicationReview::create($status_data);

        Patient::where('userId', $patient->userId)->update(['status' => 3]);

    // Return response based on status
    return response()->json([
        'message' => $request->status === 'approved' ? 'Care plan approved successfully' : 'Care plan disapproved',
        'data' => $patient,
    ], 200);
}


}
