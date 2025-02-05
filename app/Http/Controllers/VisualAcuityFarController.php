<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisualAcuityFar;
class VisualAcuityFarController extends Controller
{
    public function retrieveAll()
    {
        $visual_acuity_far = VisualAcuityFar::all();
        return response()->json(
             $visual_acuity_far);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $visualAcuityFars = [];
        foreach ($validated as $data) {
            $visualAcuityFars[] = VisualAcuityFar::create($data);
        }
    
        return response()->json($visualAcuityFars, 201);
    }
    
    
}
