<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\HMOs;
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
        $patients = Patients::all();
        return $patients;

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
        $patients = Patients::where('hospitalFileNumber', '=', "$query")
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


    public function update(Request $request, $patientId)
{
    // Find the patient by ID
    $patient = Patients::find($patientId);

    // If the patient doesn't exist, return an error response
    if (!$patient) {
        return response()->json([
            'error' => 'Patient not found',
        ], 404); // HTTP status code 404: Not Found
    }

    // Get the data from the request
    $data = $request->all();

    // Update the patient record
    $patient->update($data);

    // Return the updated patient record as a response
    return response()->json([
        'message' => 'Patient updated successfully',
        'data' => $patient,
    ], 200); // HTTP status code 200: OK
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
