<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Hub;
use App\Models\SubHub;
use App\Models\Cluster; 
use App\Models\EwalletTransaction;
use App\Models\EWallet;
use App\Models\NicratPool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HospitalController extends Controller
{
    public function RetrieveAll()
    {
        $hospitals = Hospital::with('state.zone', 'wallet_balance')
        ->where('hospitalType', 'hub')
        ->get();
        return response()->json($hospitals);
       
    }

    public function RetrieveSubhubs(Request $request)
    {
        $hub = Hub::where('hospitalId', $request->hospitalId)->first(); 
        $hospitals = SubHub::with('hospital')
        ->where('hubId', $hub->hubId)
        ->get();
        return response()->json($hospitals);
       
    }

    public function RetrieveClusters(Request $request)
    {
        $subhub = SubHub::where('hospitalId', $request->hospitalId)->first(); 
        $hospitals = Cluster::with('hospital')
        ->where('subhubId', $subhub->subhubId)
        ->get();
        return response()->json($hospitals);
       
    }

    // public function hospitalMap()
    // {
    //     $hospitals = Hospital::with('hubs.subhubs.clusters', 'state.zone', 'hospitalAdmin', 'hospitalCMD')->get();
    //     return response()->json($hospitals);
       
    // }



public function topUpEwallet(Request $request)
{
    // Get all the input data from the request
    $data = $request->all();
    $newAmount = $request->amount; // The amount to be added to the existing balance

    // Find the hospital by its ID
    $hospital = Hospital::find($request->hospitalId);
    if (!$hospital) {
        return response()->json([
            'error' => 'Hospital not found',
        ]);
    }

    // Find the ewallet for the hospital
    $ewallet = Ewallet::where('hospitalId', $hospital->hospitalId)->first();

    // If the ewallet does not exist
    if (!$ewallet) {
        return response()->json([
            'error' => 'Ewallet not found for this hospital',
        ]);
    }

    // Check the pool account balance (NicratPool model) to see if there are sufficient funds
    $pool = NicratPool::first(); // Assuming NicratPool is the model for the pool account
    if (!$pool) {
        return response()->json([
            'error' => 'Pool account not found',
        ]);
    }

    // Check if the pool has enough funds to top up the hospital's ewallet
    if ($pool->balance < $newAmount) {
        return response()->json([
            'error' => 'Insufficient funds in the pool account',
        ]);
    }

    // Start a database transaction to ensure atomicity
    DB::beginTransaction();

    try {
        // Deduct the top-up amount from the pool balance (debit pool account)
        $pool->balance -= $newAmount;
        $pool->save(); // Save the updated pool balance

        // Add the new amount to the existing hospital ewallet balance
        $ewallet->balance += $newAmount; // Add the new amount to the current balance
        $ewallet->comments = $request->comments;
        $ewallet->lastUpdatedBy = Auth::id();
        $ewallet->save(); // Save the updated ewallet balance

        // Create a transaction record in the EwalletTransaction table
        $transaction_data = $request->all();
        $transaction_data['walletId'] = $ewallet->walletId;
        $transaction_data['hospitalId'] = $request->hospitalId;
        $transaction_data['amount'] = $newAmount;
        $transaction_data['transactionType'] = 'credit';
        $transaction_data['reason'] = 'Ewallet top-up';
        $transaction_data['initiatorId'] = Auth::id();
        EwalletTransaction::create($transaction_data);

        // Commit the transaction
        DB::commit();

        return response()->json([
            'success' => 'Hospital wallet topped up successfully',
        ]);
    } catch (\Exception $e) {
        // If any error occurs, roll back all changes
        DB::rollBack();

        // Log the error (optional)
        \Log::error('Top up ewallet failed: ' . $e->getMessage());

        return response()->json([
            'error' => 'Failed to top up the hospital ewallet',
        ]);
    }
}

    

    public function getHospitalNetwork()
    {
        $nodes = [];
        $edges = [];
        $positionX = 250;
        $positionY = 0;

        $hubs = Hospital::with('hubs.subhubs.clusters')->get();
        // $hubs = Hub::with('subhubs.clusters.hospitals')->get();

        foreach ($hubs as $hubIndex => $hub) {
            $hubId = "hub_" . $hub->id;
            $nodes[] = [
                "id" => $hubId,
                "position" => ["x" => $positionX, "y" => $positionY],
                "data" => ["label" => $hub->name],
                "type" => "input",
            ];
            $prevId = $hubId;
            $subY = $positionY + 100;

            foreach ($hub->subhubs as $subhub) {
                $subhubId = "subhub_" . $subhub->id;
                $nodes[] = [
                    "id" => $subhubId,
                    "position" => ["x" => $positionX - 150, "y" => $subY],
                    "data" => ["label" => $subhub->name],
                ];
                $edges[] = ["id" => "e_" . $prevId . "_" . $subhubId, "source" => $prevId, "target" => $subhubId];

                foreach ($subhub->clusters as $cluster) {
                    $clusterId = "cluster_" . $cluster->id;
                    $nodes[] = [
                        "id" => $clusterId,
                        "position" => ["x" => $positionX + 150, "y" => $subY + 100],
                        "data" => ["label" => $cluster->name],
                    ];
                    $edges[] = ["id" => "e_" . $subhubId . "_" . $clusterId, "source" => $subhubId, "target" => $clusterId];

                    foreach ($cluster->hospitals as $hospital) {
                        $hospitalId = "hospital_" . $hospital->id;
                        $nodes[] = [
                            "id" => $hospitalId,
                            "position" => ["x" => $positionX, "y" => $subY + 200],
                            "data" => ["label" => $hospital->name],
                        ];
                        $edges[] = ["id" => "e_" . $clusterId . "_" . $hospitalId, "source" => $clusterId, "target" => $hospitalId];
                    }
                }
            }
            $positionX += 500;
        }

        return response()->json(["nodes" => $nodes, "edges" => $edges]);
    }

    public function store(Request $request)
    {
        
        $data = $request->all();
    
        $data['hospitalType'] = 'hub';
        $hospital = Hospital::firstOrcreate($data);

        $hub_details['hospitalId'] = $hospital->hospitalId;
        $hub_details['hubName'] = $hospital->hospitalShortName;
        $hub_details['stateId'] = $hospital->stateId;
        $hub_details['status'] = 'active';

        $hub = Hub::firstOrCreate($hub_details);

        $wallet['hospitalId'] = $hospital->hospitalId;
        $wallet['createdBy'] = Auth::id();
        $e_wallet = EWallet::firstOrCreate($wallet);

        $hospital->load('state.zone'); 
       
        return response()->json($hospital, 201); 
    }



    public function createSubHub(Request $request)
    {
        
        $data = $request->all();
    
        $hubHospitalId = $request->hubHospitalId;
        $hub = Hub::where('hospitalId', $hubHospitalId)->first();
        
        $data['hospitalType'] = 'subhub';
        $hospital = Hospital::create($data);

        $subhub_details['hospitalId'] = $hospital->hospitalId;
        // $subhub_details['subhubName'] = $hospital->hospitalShortName;
        $subhub_details['stateId'] = $hospital->stateId;
        $subhub_details['hubId'] = $hub->hubId;

        $subhub = SubHub::create($subhub_details);
        $hospital->load('state.zone'); 
       
        return response()->json($hospital, 201); 
    }


    public function createCluster(Request $request)
    {
        
        $data = $request->all();
    
        $subhubHospitalId = $request->subhubHospitalId;
        $subhub = SubHub::where('hospitalId', $subhubHospitalId)->first();
        
        $data['hospitalType'] = 'cluster';
        $hospital = Hospital::create($data);

        $cluster_details['hospitalId'] = $hospital->hospitalId;
        // $cluster_details['subhubName'] = $hospital->hospitalShortName;
        $cluster_details['stateId'] = $hospital->stateId;
        $cluster_details['subhubId'] = $subhub->subhubId;

        $cluster = Cluster::create($cluster_details);
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
