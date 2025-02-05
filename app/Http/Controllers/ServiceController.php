<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function retrieveAll()
    {
        $service = Service::all();
        return response()->json($service);
       
    }


    public function serviceInventory(Request $request)
    {
        $service = Service::where('serviceType', $request->category)
        ->get();
        return response()->json($service);
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
        $data['uploadedBy'] = Auth::user()->id;
        $data['productStatus'] = 'active';
        
        $service = Service::create($data);
    
       
        return response()->json($service, 201); 
    }
   
    public function update(Request $request, $serviceId)
    {
        // Find the service by ID
        $service = Service::find($serviceId);
        if (!$service) {
            return response()->json([
                'error' => 'Service not found',
            ]); 
        }
    
        $data = $request->all();
        $service->update($data);
        return response()->json([
            'message' => 'Service updated successfully',
            'data' => $service,
        ], 200);
    }


    // Delete Service
    public function deleteService($serviceId){
        $service = Service::find($serviceId);
    if ($service) {   
    $service->delete();
    return response()->json([
        'message' => 'Service deleted successfully',
    ], 200);
    } else {
        return response()->json([
            'error' => 'Service not found',
        ]);
    }
    }
    
}
