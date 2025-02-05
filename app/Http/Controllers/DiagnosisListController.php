<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisList;
class DiagnosisListController extends Controller
{
    public function retrieveAll()
    {
        $diagnosis_list = DiagnosisList::all();
        return response()->json($diagnosis_list);
       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            '*.name' => 'required|string|max:255', 
        ]);
    
        
        $diagnosis_list = [];
        foreach ($validated as $data) {
            $diagnosis_list[] = DiagnosisList::create($data);
        }
    
        return response()->json($diagnosis_list, 201);
    }
    
    
}
