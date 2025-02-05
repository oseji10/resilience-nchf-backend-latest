<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Manufacturers;
class MedicinesController extends Controller
{
    public function RetrieveAll()
    {
        $medicines = Medicines::with('manufacturer')->get();
        return response()->json($medicines);
       
    }

    public function manufacturers()
    {
        $manufacturers = Manufacturers::all();
        return response()->json($manufacturers);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $medicines = Medicines::create($data);
    
       
        return response()->json($medicines, 201); 
    }



    public function update(Request $request, $medicineId)
    {
        // Find the medicine by ID
        $medicine = Medicines::find($medicineId);
        if (!$medicine) {
            return response()->json([
                'error' => 'Drug not found',
            ]); 
        }
    
        $data = $request->all();
        $medicine->update($data);
        return response()->json([
            'message' => 'Drug updated successfully',
            'data' => $medicine,
        ], 200);
    }
    
    // Delete Drug
    public function deleteMedicine($medicineId){
        $medicine = Medicines::find($medicineId);
    if ($medicine) {
    $medicine->delete();
    }
    return response()->json($medicine, 201);
    }
    
}
