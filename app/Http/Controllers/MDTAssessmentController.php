<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDTAssessment;
use App\Models\Patient;
use App\Models\Doctors;
use App\Models\HMOs;
use App\Models\User;
use App\Models\HospitalStaff;
use App\Models\DoctorAssessment;
use App\Models\SocialWelfareAssessment;

use App\Models\CMDAssessment;
use App\Models\NICRATAssessment;
use App\Models\ApplicationReview;
use Illuminate\Support\Facades\Auth;

class MDTAssessmentController extends Controller
{
    public function RetrieveAll()
    {
        $mdtassessment = MDTAssessment::all();
        return response()->json($mdtassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $mdtassessment = MDTAssessment::create($data);
    
       
        return response()->json($mdtassessment, 201); 
    }





    public function MDTPatients(Request $request)
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
        ->where('status', 4)
        ->orWhere('status', 5)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details',
        'social_welfare_assessment',
        'mdt_assessment'
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }



    public function MDTPendingPatients(Request $request)
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
        ->where('status', 4)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details',
        'social_welfare_assessment',
        'mdt_assessment',
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }


// ALL REVIEWED APPLICATIONS 
    public function MDTReviewedPatients(Request $request)
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
        ->where('status', 5)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details',
        'social_welfare_assessment' ,
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }




    

// MDT ASSESSMENT
public function MDTAssessment(Request $request)
{
   

    // Find the patient by ID
    $patient = Patient::findOrFail($request->patientId);

    // Prepare data for update
    $data = [
        'patientUserId' => $patient->userId,
        'reviewerId' => Auth::id(),
        'diagnosticProceedures' => $request->diagnosticProceedures,
        'costAssociatedWithSurgery' => $request->costAssociatedWithSurgery,
        'servicesToBereceived' => $request->servicesToBereceived,
        'medications' => $request->medications,
        'radiotherapyCost' => $request->radiotherapyCost,
        'status' => 5, 
    ];

    // Update patient record
    // $patient->update($data);
  MDTAssessment::firstOrCreate($data);

    $status_data['patientUserId'] = $patient->userId;
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 2;
        $status_data['statusId'] = 5;

        $application_status = ApplicationReview::create($status_data);

        Patient::where('userId', $patient->userId)->update(['status' => 5]);

    // Return response based on status
            return response()->json([
            'message' => $request->status === 'approved' ? 'MDT form submitted successfully' : 'MDT plan disapproved',
            'data' => $patient,
       
    ], 200);
}

}
