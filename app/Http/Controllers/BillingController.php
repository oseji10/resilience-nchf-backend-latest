<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicines;
use App\Models\Billing;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Patient;
use App\Models\Service;
use App\Models\HospitalStaff;
use App\Models\Ewallet;
use App\Models\EwalletTransaction;

use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Support\Facades\Validator;

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


public function createBilling(Request $request)
{
    $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;

    // Generate a unique transaction ID
    $transactionId = strtoupper(Str::random(2)) . mt_rand(1000000000, 9999999999);

    // Validate incoming data
    $request->validate([
        'patientId' => 'nullable',
        // 'hospitalId' => 'required', // Ensure hospitalId is provided
        'prescriptions' => 'required|array',
        'prescriptions.*.inventoryId' => 'required',
        'prescriptions.*.dispensedQuantity' => 'required|integer|min:1',
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        $billedItems = [];
        $totalAmount = 0; // Store total cost for all prescriptions

        foreach ($request->prescriptions as $item) {
            $inventory = Inventory::find($item['inventoryId']);
            if (!$inventory) {
                DB::rollBack();
                return response()->json(['message' => 'One or more inventory items not found'], 404);
            }

            if ($inventory->quantityReceived < ($inventory->quantitySold + $item['dispensedQuantity'])) {
                DB::rollBack();
                return response()->json(['message' => 'Insufficient stock for inventory ID ' . $item['inventoryId']], 400);
            }

            $product = Product::find($item['inventoryId']); 
            if (!$product) {
                DB::rollBack();
                return response()->json(['message' => 'Product not found'], 404);
            }

            $totalCost = $product->productCost * $item['dispensedQuantity'];
            $totalAmount += $totalCost; // Accumulate total cost

            $billing = Billing::create([
                'transactionId' => $transactionId,
                'patientId'     => $request->patientId,
                'productId'     => $item['inventoryId'],
                'billingType'   => 'Product',
                'categoryType'  => 'Prescription',
                'inventoryId'   => $item['inventoryId'],
                'quantity'      => $item['dispensedQuantity'],
                'cost'          => $totalCost,
                'billedBy'      => Auth::user()->id,
                'paymentStatus' => 'paid',
            ]);

            // Update inventory
            $inventory->quantitySold += $item['dispensedQuantity'];
            $inventory->save();

            $billedItems[] = $billing;
        }

        // Fetch the hospital e-wallet
        $wallet = Ewallet::where('hospitalId', $hospitalId)->first();

        if (!$wallet) {
            DB::rollBack();
            return response()->json(['message' => 'Hospital e-wallet not found'], 404);
        }

        // Check if wallet has sufficient balance
        if ($wallet->balance < $totalAmount) {
            DB::rollBack();
            return response()->json(['message' => 'Insufficient balance in hospital e-wallet'], 400);
        }

        // Deduct total cost from e-wallet
        $wallet->balance -= $totalAmount;
        $wallet->save();

         // Log transaction
         EwalletTransaction::create([
            'walletId' => $wallet->walletId,
            'hospitalId' => $hospitalId,
            'amount' => $totalAmount,
            'transactionType' => 'debit',
            'reason' => 'Patient billing',
            'transactionReference' => $transactionId,
            'initiatorId' => $hospitalAdminId,
        ]);
        // Commit transaction
        DB::commit();

        return response()->json([
            'message' => 'Billing records created successfully, e-wallet debited',
            'billings' => $billedItems,
            'remaining_balance' => $wallet->balance
        ], 201);

    } catch (\Exception $e) {
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




    // Create prescription
    public function storePrescription(Request $request)
    {

        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;

        $prescriptionId = mt_rand(10000000, 99999999);
        // Validate the request
        $validator = Validator::make($request->all(), [
            'patientId' => 'nullable',
            'prescriptions' => 'required|array|min:1',
            'prescriptions.*.type' => 'required|in:product,service',
            'prescriptions.*.productId' => 'nullable|exists:products,productId',
            'prescriptions.*.serviceId' => 'nullable|exists:services,serviceId',
            'prescriptions.*.quantity' => 'nullable|integer|min:1',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create a new prescription
        $prescription = Prescription::create([
            'patientId' => $request->patientId,
            'comments' => $request->comments,
            'prescriptionId' => $prescriptionId,
            'prescribedBy' => Auth::id(),
            'hospitalId' => $hospitalId,
        ]);

        // Store prescription items
        foreach ($request->prescriptions as $item) {
            PrescriptionItem::create([
                'prescriptionId' => $prescriptionId,
                'type' => $item['type'],
                'productId' => $item['type'] === 'product' ? $item['productId'] : null,
                'serviceId' => $item['type'] === 'service' ? $item['serviceId'] : null,
                'quantity' => $item['type'] === 'product' ? $item['quantity'] : null,
            ]);
        }

        return response()->json([
            'message' => 'Prescription stored successfully!',
            'prescription' => $prescription->load('items')
        ], 201);
    }
    

// Hospital Prescriptions
    public function hospitalPrescriptions(Request $request)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        $prescriptions = Prescription::with('patient.user', 'patient.cancer')
        ->whereHas('patient.user', function ($query) {
            $query->where('role', 1); // Ensure user has roleId = 1
        })
        ->whereHas('patient', function ($query) use ($hospitalId) {
            $query->where('hospital', $hospitalId); // Ensure user has roleId = 1
        })
        ->orderBy('created_at', 'desc')
        ->get();
        

    
        return response()->json($prescriptions);
    }

    
    public function patientDrugPrescriptions($prescriptionId)
    {
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        $prescriptions = PrescriptionItem::where('prescriptionId', $prescriptionId)
            ->where('type', 'product')
            ->with(['product' => function ($query) use ($hospitalId) {
                $query->with(['stock' => function ($stockQuery) use ($hospitalId) {
                    $stockQuery->where('hospitalId', $hospitalId); // Ensure stock is checked for the same hospital
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($prescription) {
                // Ensure stock exists before accessing properties
                $stock = $prescription->product->stock ?? null;
                $quantityReceived = $stock->quantityReceived ?? 0;
                $quantitySold = $stock->quantitySold ?? 0;
    
                // Calculate stock availability
                $quantity_in_stock = max($quantityReceived - $quantitySold, 0);
    
                // Add stock info to the response
                $prescription->stock_available = $quantity_in_stock;
                $prescription->out_of_stock = $quantity_in_stock <= 0;
    
                return $prescription;
            });
    
        return response()->json($prescriptions);
    }
    


}
