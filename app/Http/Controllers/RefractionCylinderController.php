<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefractionCylinder;
class RefractionCylinderController extends Controller
{
    public function retrieveAll()
    {
        $refraction_cylinder = RefractionCylinder::all();
        return response()->json($refraction_cylinder);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $refraction_cylinder = [];
        foreach ($validated as $data) {
            $refraction_cylinder[] = RefractionCylinder::create($data);
        }
    
        return response()->json($refraction_cylinder, 201);
    }
    
    
}
