<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiefComplaint;
class ChiefComplaintController extends Controller
{
    public function retrieveAll()
    {
        $chief_complaint = ChiefComplaint::all();
        return response()->json($chief_complaint);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $chief_complaint = [];
        foreach ($validated as $data) {
            $chief_complaint[] = ChiefComplaint::create($data);
        }
    
        return response()->json($chief_complaint, 201);
    }
    
    
}
