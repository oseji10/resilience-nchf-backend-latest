<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctors;
class DoctorsController extends Controller
{
    public function RetrieveAll()
    {
        $doctors = Doctors::all();
        return response()->json($doctors);
       
    }

    public function store(Request $request)
    {
        // Directly get the data from the request
        $data = $request->all();
    
        // Create a new user with the data (ensure that the fields are mass assignable in the model)
        $doctors = Doctors::create($data);
    
        // Return a response, typically JSON
        return response()->json($doctors, 201); // HTTP status code 201: Created
    }
    
}
