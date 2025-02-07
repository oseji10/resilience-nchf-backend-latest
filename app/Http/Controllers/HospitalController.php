<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Hub;
use App\Models\SubHub;
use App\Models\Cluster; 
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
    
}
