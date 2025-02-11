<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorAssessment;

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
    // ->whereHas('status', function ($query) {
    //     $query->where('statusId', 3); 
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


}
