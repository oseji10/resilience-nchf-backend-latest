<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Hub;
use App\Models\SubHub;
use App\Models\Cluster; 
use App\Models\EwalletTransaction;
class HospitalController extends Controller
{
    public function RetrieveAll()
    {
        $hospitals = Hospital::all();
        return response()->json($hospitals);
       
    }

    public function hospitalMap()
    {
        $hospitals = Hospital::with('hubs.subhubs.clusters', 'state.zone', 'hospitalAdmin', 'hospitalCMD')->get();
        return response()->json($hospitals);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $hospital = Hospital::create($data);
        $hospital->load('state.zone'); 
       
        return response()->json($hospital, 201); 
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
    

    public function creditHospital($hospitalId, $amount)
    {
        $hospital = Hospital::find($hospitalId);
        if (!$hospital) {
            return response()->json(['error' => 'Hospital not found'], 404);
        }
    
        // Increase hospital's wallet balance
        $hospital->balance += $amount;
        $hospital->save();
    
        // Log transaction
        EwalletTransaction::create([
            'hospitalId' => $hospitalId,
            'amount' => $amount,
            'type' => 'credit',
            'reason' => 'NICRAT Wallet Funding'
        ]);
    
        return response()->json(['message' => 'Wallet funded successfully', 'balance' => $hospital->balance]);
    }
}
