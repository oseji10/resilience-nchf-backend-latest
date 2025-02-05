<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefractionPrism;
class RefractionPrismController extends Controller
{
    public function retrieveAll()
    {
        $refraction_prism = RefractionPrism::all();
        return response()->json($refraction_prism);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $refraction_prism = [];
        foreach ($validated as $data) {
            $refraction_prism[] = RefractionPrism::create($data);
        }
    
        return response()->json($refraction_prism, 201);
    }
    
    
}
