<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialWelfareAssessment;
use Illuminate\Support\Facades\Auth;

use App\Models\Patient;
use App\Models\User;
use App\Models\HospitalStaff;
use App\Models\DoctorAssessment;

use App\Models\ApplicationReview;

class SocialWelfareAssessmentController extends Controller
{
    public function RetrieveAll()
    {
        $socialwelfareassessment = SocialWelfareAssessment::all();
        return response()->json($socialwelfareassessment);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $socialwelfareassessment = SocialWelfareAssessment::create($data);
    
       
        return response()->json($socialwelfareassessment, 201); 
    }



    
    public function socialWelfarePatients(Request $request)
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
        ->where('status', 3)
        ->orWhere('status', 4)
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



    public function socialWelfarePendingPatients(Request $request)
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
        ->where('status', 3)
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


// ALL REVIEWED APPLICATIONS 
    public function socialWelfareReviewedPatients(Request $request)
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
        'social_welfare_assessment' ,
    ])
    ->orderBy('updated_at', 'desc')
    ->get();

    
        return response()->json($patients);
    }


}
