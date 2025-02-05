<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function retrieveAll()
    {
        $product = Product::all();
        return response()->json($product);
       
    }


    public function retrieveMedicines()
    {
        $product = Product::where('productType', 'Medicine')
        ->get();
        return response()->json($product);
       
    }

    public function retrieveLenses()
    {
        $product = Product::where('productType', 'Lens')->get();
        return response()->json($product);
       
    }


    public function retrieveFrames()
    {
        $product = Product::where('productType', 'Frame')->get();
        return response()->json($product);
       
    }


    public function retrieveAccessories()
    {
        $product = Product::where('productType', 'Accessory')->get();
        return response()->json($product);
       
    }


    public function store(Request $request)
    {
        
        $data = $request->all();
        $data['uploadedBy'] = Auth::user()->id;
        $data['productStatus'] = 'active';
        
        $product = Product::create($data);
    
       
        return response()->json($product, 201); 
    }
   
    public function update(Request $request, $productId)
    {
        // Find the product by ID
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ]); 
        }
    
        $data = $request->all();
        $product->update($data);
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }


    // Delete Product
    public function deleteProduct($productId){
        $product = Product::find($productId);
    if ($product) {   
    $product->delete();
    return response()->json([
        'message' => 'Product deleted successfully',
    ], 200);
    } else {
        return response()->json([
            'error' => 'Product not found',
        ]);
    }
    }
    
}
