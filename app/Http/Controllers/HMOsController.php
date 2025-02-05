<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HMOs;
class HMOsController extends Controller
{
   

    public function RetrieveAll()
    {
        $hmos = HMOs::all();
        return response()->json($hmos);
       
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        
        $hmos = HMOs::create($data);
    
       
        return response()->json($hmos, 201); 
    }
    
}
