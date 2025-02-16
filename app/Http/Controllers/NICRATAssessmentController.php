<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\HospitalStaff;
use App\Models\NICRATAssessment;
use App\Models\ApplicationReview;
use Illuminate\Support\Facades\Auth;

class NICRATAssessmentController extends Controller
{
    public function RetrieveAll()
    {
        $nicratassessment = NICRATAssessment::all();
        return response()->json($nicratassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $nicratassessment = NICRATAssessment::create($data);
    
       
        return response()->json($nicratassessment, 201); 
    }



    

    public function NICRATPatients(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::
        // where('hospital', $hospitalId)
        where('status', 6)
        ->orWhere('status', 7)
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
        'cmd_assessment',
        'nicrat_assessment'
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }



    public function NICRATPendingPatients(Request $request)
    {
        // $hospitalAdminId = Auth::id(); 
    
        // // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        // $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        // if (!$currentHospital) {
        //     return response()->json(['message' => 'Hospital admin not found'], 404);
        // }
    
        // $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::
        // where('hospital', $hospitalId)
        where('status', 6)
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
        'cmd_assessment',
        'nicrat_assessment'
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }


// ALL REVIEWED APPLICATIONS 
    public function NICRATReviewedPatients(Request $request)
    {
        // $hospitalAdminId = Auth::id(); 
    
        // // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        // $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        // if (!$currentHospital) {
        //     return response()->json(['message' => 'Hospital admin not found'], 404);
        // }
    
        // $hospitalId = $currentHospital->hospitalId;
    
        // Retrieve patients who belong to the same hospital and have users with roleId = 1
        $patients = Patient::
        // where('hospital', $hospitalId)
        where('status', 7)
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details',
        'social_welfare_assessment' ,
        'mdt_assessment',
        'cmd_assessment',
        'nicrat_assessment'
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }




    

// MDT ASSESSMENT
public function NICRATAssessment(Request $request)
{
   

    // Find the patient by ID
    $patient = Patient::findOrFail($request->patientId);

    // Prepare data for update
    $data = [
        'patientUserId' => $patient->userId,
        'reviewerId' => Auth::id(),
        'comments' => $request->comments,
        'status' => 7, 
    ];

    // Update patient record
    // $patient->update($data);
    NICRATAssessment::firstOrCreate($data);

    $status_data['patientUserId'] = $patient->userId;
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 11;
        $status_data['statusId'] = 7;

        $application_status = ApplicationReview::create($status_data);

        Patient::where('userId', $patient->userId)->update(['status' => 7]);

    // Return response based on status
            return response()->json([
            'message' => $request->status === 'approved' ? 'Patient successfully approved' : 'Patient approval declined',
            'data' => $patient,
       
    ], 200);
}

}
