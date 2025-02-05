<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Inventory;
class InventoryController extends Controller
{
    public function RetrieveAll()
    {
        $inventories = Inventory::with('product')->get();
        return response()->json($inventories);
       
    }



    public function retrieveMedicines()
    {
        $product = Inventory::where('inventoryType', 'Medicine')
        ->with('product')
        ->get();
        return response()->json($product);
       
    }

    public function retrieveLenses()
    {
        $product = Inventory::where('inventoryType', 'Lens')
        ->with('product')
        ->get();
        return response()->json($product);
       
    }


    public function retrieveFrames()
    {
        $product = Inventory::where('inventoryType', 'Frame')
        ->with('product')
        ->get();
        return response()->json($product);
       
    }


    public function retrieveAccessories()
    {
        $product = Inventory::where('inventoryType', 'Accessory')
        ->with('product')
        ->get();
        return response()->json($product);
       
    }

    public function billingInventory(Request $request)
    {
        $product = Inventory::where('inventoryType', $request->category)
        ->with('product')
        ->get();
        return response()->json($product);
       
    }


    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $inventories = Inventory::create($data);
    
       
        return response()->json($inventories, 201); 
    }
   
    public function update(Request $request, $inventoryId)
    {
        // Find the inventory by ID
        $inventory = Inventory::find($inventoryId);
        if (!$inventory) {
            return response()->json([
                'error' => 'Inventory not found',
            ]); 
        }
    
        $data = $request->all();
        $inventory->update($data);
        return response()->json([
            'message' => 'Inventory updated successfully',
            'data' => $inventory,
        ], 200);
    }


    // Delete Inventory
    public function deleteInventory($inventoryId){
        $inventory = Inventory::find($inventoryId);
    if ($inventory) {   
    $inventory->delete();
    return response()->json([
        'message' => 'Inventory deleted successfully',
    ], 200);
    } else {
        return response()->json([
            'error' => 'Inventory not found',
        ]);
    }
    }
    
}
