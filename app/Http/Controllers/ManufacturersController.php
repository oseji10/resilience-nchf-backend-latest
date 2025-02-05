<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Manufacturers;
class ManufacturersController extends Controller
{
   

    public function RetrieveAll()
    {
        $manufacturers = Manufacturers::all();
        return response()->json($manufacturers);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $manufacturers = Manufacturers::create($data);
    
       
        return response()->json($manufacturers, 201); 
    }


    public function update(Request $request, $manufacturerId)
    {
        // Find the medicine by ID
        $manufacturer = Manufacturers::find($manufacturerId);
        if (!$manufacturer) {
            return response()->json([
                'error' => 'Manufacturer not found',
            ]); 
        }
    
        $data = $request->all();
        $manufacturer->update($data);
        return response()->json([
            'message' => 'Manufacturer updated successfully',
            'data' => $manufacturer,
        ], 200);
    }
    
    // Delete Drug
    public function deleteManufacturer($manufacturerId){
        $manufacturer = Manufacturers::find($manufacturerId);
    if ($manufacturer) {
    $manufacturer->delete();
    }
    return response()->json($manufacturer, 201);
    }
    
    
}
