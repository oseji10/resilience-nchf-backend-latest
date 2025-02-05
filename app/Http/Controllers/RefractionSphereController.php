<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefractionSphere;
class RefractionSphereController extends Controller
{
    public function retrieveAll()
    {
        $refraction_sphere = RefractionSphere::all();
        return response()->json($refraction_sphere);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $visualAcuityFars = [];
        foreach ($validated as $data) {
            $visualAcuityFars[] = RefractionSphere::create($data);
        }
    
        return response()->json($visualAcuityFars, 201);
    }
    
    
}
