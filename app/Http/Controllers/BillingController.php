<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Billing;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Patients;
use App\Models\Service;

use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

class BillingController extends Controller
{

    

public function generateCode()
{
    $randomNumber = mt_rand(1000000000, 9999999999); // Generate a 10-digit number
    $randomLetters = strtoupper(Str::random(2)); // Generate 2 random uppercase letters

    $code = $randomLetters . $randomNumber; // Combine letters and number

    return response()->json(['code' => $code]);
}


public function RetrieveAll()
{
    // Retrieve all the transactions with related billing, patient, product, and service information
    $transactions = Billing::selectRaw('transactionId, created_at, paymentStatus, paymentMethod, GROUP_CONCAT(billingId) as billing_ids, patientId, SUM(cost*quantity) as total_cost')
        ->with('patient.doctor')   // Eager load the patient relationship
        ->with('product')   // Eager load the product relationship
        ->with('service')   // Eager load the service relationship
        ->groupBy('transactionId', 'patientId', 'created_at', 'paymentStatus', 'paymentMethod')  // Group by necessary fields
        ->get();

    // Loop through each transaction and fetch associated transactions tied to the same transactionId
    foreach ($transactions as $transaction) {
        $transaction->relatedTransactions = Billing::where('transactionId', $transaction->transactionId)->get();
    }

    // Return the result with the related transactions
    return response()->json($transactions);
}


public function updateBillingStatus(Request $request)
{
    // Find the transactions by transactionId
    $transactions = Billing::where('transactionId', $request->transactionId)->get();

    if ($transactions->isEmpty()) {
        return response()->json([
            'error' => 'Transactions not found',
        ], 404);
    }
    $data = $request->all();
    $data['paymentStatus'] = 'paid'; // Set paymentStatus to 'paid'
    $data['paymentDate'] = now(); // Set paymentDate to current date

    // Update each transaction in the collection
    foreach ($transactions as $transaction) {
        $transaction->update($data);
    }

    return response()->json([
        'message' => 'Transactions updated successfully',
        'data' => $transactions,
    ], 200);
}


    public function store(Request $request)
    {

     // Generate a unique transaction ID
    $transactionId = strtoupper(Str::random(2)) . mt_rand(1000000000, 9999999999);

        // Validate incoming data
        $request->validate([
            'patientId'     => 'nullable',
            'items'         => 'nullable|array', // Ensure 'items' is an array
            'items.*.inventoryId' => 'nullable',
            'items.*.quantity'    => 'nullable|integer|min:1',
        ]);
    
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();
    
        try {
            $billedItems = [];
    
            foreach ($request->items as $item) {
                if ($item['inventoryType'] === 'Products') {  // Ensure correct inventoryType
                    // Find the inventory item
                    $inventory = Inventory::find($item['inventoryId']);
    
                    if (!$inventory) {
                        // Rollback transaction if inventory is not found
                        DB::rollBack();
                        return response()->json(['message' => 'One or more inventory items not found'], 404);
                    }
    
                    // Ensure quantitySold is initialized to 0 if null
                    $inventory->quantitySold = $inventory->quantitySold ?? 0;
    
                    // Check stock availability
                    if ($inventory->quantityReceived < ($inventory->quantitySold + $item['quantity'])) {
                        DB::rollBack();
                        return response()->json(['message' => 'Insufficient stock for ' . $inventory->product->productName], 400);
                    }
    
                    // Handle products
                    $product = Product::find($item['productId']);
                    if (!$product) {
                        DB::rollBack();
                        return response()->json(['message' => 'Product not found'], 404);
                    }
    
                    $totalCost = $product->productCost * $item['quantity'];
    
                    $billing = Billing::create([
                        'transactionId' => $transactionId,
                        'patientId'     => $request->patientId,
                        'productId'     => $item['productId'],
                        'billingType'   => 'Product',
                        'categoryType'  => $item['categoryType'],
                        'inventoryId'   => $item['inventoryId'],
                        'quantity'      => $item['quantity'],
                        'cost'          => $totalCost,
                        'billedBy'      => Auth::user()->id,
                        'paymentStatus' => 'pending',
                    ]);
    
                    // Update inventory
                    $inventory->quantitySold += $item['quantity'];
                    $inventory->save();
                } 
                else { // This handles services
                    // Handle services
                    $service = Service::find($item['serviceId']);
                    if (!$service) {
                        DB::rollBack();
                        return response()->json(['message' => 'Service not found'], 404);
                    }
    
                    $totalCost = $service->serviceCost * $item['quantity'];
    
                    $billing = Billing::create([
                        'transactionId' => $transactionId,
                        'patientId'     => $request->patientId,
                        'serviceId'     => $item['serviceId'], // Fixed serviceId
                        'billingType'   => 'Service',
                        'categoryType'  => $item['categoryType'],
                        'quantity'      => $item['quantity'],
                        'cost'          => $totalCost,
                        'billedBy'      => Auth::user()->id,
                        'paymentStatus' => 'pending',
                    ]);
                }
    
                // Add billing item to array
                $billedItems[] = $billing;
            }
    
            // Commit transaction
            DB::commit();
    
            // Return success response
            return response()->json(['message' => 'Billing records created successfully', 'billings' => $billedItems], 201);
    
        } catch (\Exception $e) {
            // Rollback transaction on any exception
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong. Please try again.', 'error' => $e->getMessage()], 500);
        }
    }
    

   
    public function update(Request $request, $billingId)
    {
        // Find the billing by ID
        $billing = Billing::find($billingId);
        if (!$billing) {
            return response()->json([
                'error' => 'Billing not found',
            ]); 
        }
    
        $data = $request->all();
        $billing->update($data);
        return response()->json([
            'message' => 'Billing updated successfully',
            'data' => $billing,
        ], 200);
    }


    // Delete Billing
    public function deleteBilling($billingId){
        $billing = Billing::find($billingId);
    if ($billing) {   
    $billing->delete();
    return response()->json([
        'message' => 'Billing deleted successfully',
    ], 200);
    } else {
        return response()->json([
            'error' => 'Billing not found',
        ]);
    }
    }
    
}
