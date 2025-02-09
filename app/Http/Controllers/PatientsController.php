<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctors;
use App\Models\HMOs;
use App\Models\User;
use App\Models\HospitalStaff;
use App\Models\DoctorAssessment;
use App\Models\ApplicationReview;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
    public function NICRATRetrieveAll(Request $request)
    {
        $limit = $request->input('limit', 10);
        $searchQuery = $request->input('query');
        
        $patients = Patients::with('doctor', 'hmo')
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->where('firstName', 'like', "%{$searchQuery}%")
                    ->orWhere('lastName', 'like', "%{$searchQuery}%")
                    ->orWhere('otherNames', 'like', "%{$searchQuery}%")
                    ->orWhere('phoneNumber', 'like', "%{$searchQuery}%")
                    ->orWhere('patientId', 'like', "%{$searchQuery}%")
                    ->orWhere('hospitalFileNumber', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%")
                    ->orWhereRaw("CONCAT(firstName, ' ', lastName) LIKE ?", ["%{$searchQuery}%"])
                    ->orWhereRaw("CONCAT(firstName, ' ', lastName, ' ', otherNames) LIKE ?", ["%{$searchQuery}%"]);
            })
            ->orderBy('patientId', 'desc')
            ->paginate($limit);
    
        return response()->json([
            'data' => $patients->items(),
            'total' => $patients->total(),
            'current_page' => $patients->currentPage(),
            'last_page' => $patients->lastPage(),
        ]);
    }
    
    
    public function RetrieveAll(Request $request){
        $patients = Patient::all();
        return $patients;

    }


    public function hospitalPatients(Request $request)
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
    ->whereHas('user', function ($query) {
        $query->where('role', 1); // Ensure user has roleId = 1
    })
    ->with([
        'doctor',
        'user',
        'cancer',
        'status.status_details' => function ($query) {
            $query->latest()->limit(1); // Get only the latest status detail
        }
    ])
    ->get();

    
        return response()->json($patients);
    }



    public function hospitalDoctors(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;

        // Retrieve doctors who belong to the same hospital
        $doctors = User::where('role', 2)
            ->whereHas('hospital_admins', function ($query) use ($hospitalId) { // Pass hospitalId into closure
                $query->where('hospitalId', $hospitalId);
            })
            ->get();
        
    
        return response()->json($doctors);
    }
    
    

    public function retrieveAllPatients()
    {
        $patients = Patients::with('doctor', 'hmo')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(); 
            return response()->json($patients); 
    }
    

    public function searchPatient(Request $request)
    {
        $query = $request->query('queryParameter'); // Retrieve query parameter
        $patients = Patient::where('hospitalFileNumber', '=', "$query")
            ->orWhere('phoneNumber', '=', "$query")
            ->orWhere('email', '=', "$query")
            ->orWhere('patientId', '=', "$query")
            ->get();
        return response()->json($patients);
    }
    

    public function store(Request $request)
    {
        // Directly get the data from the request
        $data = $request->all();
    
        // Create a new user with the data (ensure that the fields are mass assignable in the model)
        $patients = Patients::create($data);
    
        // Return a response, typically JSON
        return response()->json([ $patients,
        ], 201); // HTTP status code 201: Created
    }


    public function assignDoctor(Request $request)
{
    // Find the patient by ID
    $patient = Patient::find($request->patientId);

    // If the patient doesn't exist, return an error response
    if (!$patient) {
        return response()->json([
            'error' => 'Patient not found',
        ], 404); // HTTP status code 404: Not Found
    }

    // Get the data from the request
    $data['doctor'] = $request->doctorId;

    // Update the patient record
    $patient->update($data);

    // Return the updated patient record as a response
    return response()->json([
        'message' => 'Patient updated successfully',
        'data' => $patient,
    ], 200); // HTTP status code 200: OK
}



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
        'status' => $request->status, // Set approved or disapproved
    ];

    // Update patient record
    // $patient->update($data);
    DoctorAssessment::firstOrCreate($data);

    $status_data['patientUserId'] = $patient->userId;
        $status_data['reviewerId'] = Auth::id();
        $status_data['reviewerRole'] = 2;
        $status_data['statusId'] = 3;

        $application_status = ApplicationReview::create($status_data);
    // Return response based on status
    return response()->json([
        'message' => $request->status === 'approved' ? 'Care plan approved successfully' : 'Care plan disapproved',
        'data' => $patient,
    ], 200);
}


// Delete Patient
public function deletePatient($patientId){
    $patient = Patients::find($patientId);
if ($patient) {
$patient->delete();
}
return response()->json($patient, 201);
}
    
}
