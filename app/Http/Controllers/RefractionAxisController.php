<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefractionAxis;
class RefractionAxisController extends Controller
{
    public function retrieveAll()
    {
        $refraction_axis = RefractionAxis::all();
        return response()->json($refraction_axis);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $visualAcuityFars = [];
        foreach ($validated as $data) {
            $visualAcuityFars[] = RefractionAxis::create($data);
        }
    
        return response()->json($visualAcuityFars, 201);
    }
    
    
}
