<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisualAcuityNear;
class VisualAcuityNearController extends Controller
{
    public function retrieveAll()
    {
        $visual_acuity_near = VisualAcuityNear::all();
        return response()->json($visual_acuity_near);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $visualAcuityNears = [];
        foreach ($validated as $data) {
            $visualAcuityNears[] = VisualAcuityNear::create($data);
        }
    
        return response()->json($visualAcuityNears, 201);
    }
    
    
}
