<?php

namespace App\Http\Controllers;
use WaAPI\WaAPI;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;
use App\Mail\AdminWelcomeEmail;
use GuzzleHttp\Client;
use App\Models\Hospital;
use App\Models\HospitalStaff;
use App\Models\Roles;
use App\Models\ApplicationReview;
use App\Models\StatusList;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Queue;
use App\Jobs\SendSMSJob;



class UserController extends Controller
{
    public function hospitalStaff()
    {
        // Get logged-in hospital admin ID
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        $hospitalId = $currentHospital->hospitalId;
    
        // Get users belonging to the same hospital by joining hospital_admins
        $users = User::with(['role', 'hospital_admins.hospital'])
            ->whereHas('hospital_admins', function ($query) use ($hospitalId) {
                $query->where('hospitalId', $hospitalId);
            })
            ->get()
            ->makeHidden(['password']);
    
        return response()->json($users, 200);
    }
    

    public function hospitalAdmins()
    {
        $users = User::with('role', 'hospital_admins.hospital')->where('role', '=', '6')->get()->makeHidden(['password']);
        return response()->json($users, 201);
    }
    
    public function cmds()
    {
        $users = User::with('role', 'hospital_admins.hospital')->where('role', '=', '7')->get()->makeHidden(['password']);
        return response()->json($users, 201);
    }

    public function clinic_receptionists()
    {
        $users = User::with('role')
        ->where('role', '=', '2')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function front_desk()
    {
        $users = User::with('role')
        ->where('role', '=', '3')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function doctors()
    {
        $users = User::with('role')
        ->where('role', '=', '4')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function workshop_receptionists()
    {
        $users = User::with('role')
        ->where('role', '=', '5')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function nurses()
    {
        $users = User::with('role')
        ->where('role', '=', '6')
        ->get();
        return response()->json($users, 201); 
       
    }
    


    
private function sendSMS($phone, $smsMessage)
{
    $apiKey = env('SMSLIVEapiKey');
    $url = env('SMSLIVEurl');

    // Convert phone number to international format
    if (substr($phone, 0, 1) === "0") {
        $phone = "+234" . substr($phone, 1);
    }
    Log::info("Phone number: " . $phone);
    try {
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->request('POST', $url, [
            'headers' => [
                'Authorization' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'mobileNumber' => $phone,
                'messageText' => $smsMessage,
                'senderID' => env('SMSLIVESenderID'), // Replace with sender name (if required)
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;

    } catch (\Exception $e) {
        Log::error("SMS sending failed: " . $e->getMessage());
        return false;
    }
}

public function createHospitalStaff(Request $request)
{
    try {
        // Get logged in user admin
        $hospitalAdminId = Auth::id(); 
    
        // Retrieve the hospitalId of the logged-in admin from the HospitalStaff table
        $currentHospital = HospitalStaff::where('userId', $hospitalAdminId)->first();
    
        if (!$currentHospital) {
            return response()->json(['message' => 'Hospital admin not found'], 404);
        }
    
        
        // Generate a random password
        $defaultPassword = strtoupper(Str::random(8)); 
        $data = $request->all();
        $data['password'] = Hash::make($defaultPassword);
        $roleId = $request->role;
        $hospitalId = $currentHospital->hospitalId;

        // Extract user details
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone = $request->phoneNumber; // User's phone number

        // Query the hospital name using the hospitalId
        $hospital = Hospital::find($hospitalId);
        $hospitalName = $hospital->hospitalName;
        $hospitalShortName = $hospital->hospitalShortName;

        // Query the role name using the roleId
        $role = Roles::find($roleId);
        $roleName = $role->roleName;
        
        
        $data['role'] = $role->roleId;
        
        // Create user
        $user = User::create($data);
        
        $staff['hospitalId'] = $hospitalId;
        $staff['userId'] = $user->id;
        if($hospital){
            HospitalStaff::create($staff);
        }

        // Send welcome email with the role and hospital names
        Mail::to($email)->send(new AdminWelcomeEmail($email, $firstName, $lastName, $hospitalName, $roleName, $defaultPassword));

        // // Send SMS with the role and hospital names
        // $smsMessage = "Hello $firstName, You have just been added as an $roleName at $hospitalShortName. Your temporary password is: $defaultPassword.";
        // $this->sendSMS($phone, $smsMessage);

        return response()->json([
            'success' => true,
            'message' => "$roleName for $hospitalName has been added successfully. A welcome email and SMS notification have been sent.",
            'user' => $user
        ], 201);
        

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'User registration failed. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function createHospitalAdmin(Request $request)
{
    try {
        // Generate a random password
        $defaultPassword = strtoupper(Str::random(8)); 
        $data = $request->all();
        $data['password'] = Hash::make($defaultPassword);
        // $roleId = $request->role;
        $hospitalId = $request->hospital;

        // Extract user details
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone = $request->phoneNumber; // User's phone number

        // Query the hospital name using the hospitalId
        $hospital = Hospital::find($hospitalId);
        $hospitalName = $hospital->hospitalName;
        $hospitalShortName = $hospital->hospitalShortName;

        // Query the role name using the roleId
        // $roleName = "Hospital Admin";
        // $role = Roles::where('roleName', 'like', "%$roleName%")->first();

        
        $role = Roles::where('roleId', '=', "6")->first();
        $data['role'] = $role->roleId;
        $roleName = $role->roleName;
        // Create user
        $user = User::create($data);
        
        $staff['hospitalId'] = $hospitalId;
        $staff['userId'] = $user->id;
        if($hospital){
            HospitalStaff::create($staff);
        }

        // Send welcome email with the role and hospital names
        Mail::to($email)->send(new AdminWelcomeEmail($email, $firstName, $lastName, $hospitalName, $roleName, $defaultPassword));

        // // Send SMS with the role and hospital names
        $smsMessage = "Hello $firstName, You have just been added as an $roleName at $hospitalShortName. Your temporary password is: $defaultPassword.";
        $this->sendSMS($phone, $smsMessage);

        return response()->json([
            'success' => true,
            'message' => "$roleName for $hospitalName has been added successfully. A welcome email and SMS notification have been sent.",
            'user' => $user
        ], 201);
        

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'User registration failed. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function createCMD(Request $request)
{
    try {
        // Generate a random password
        $defaultPassword = strtoupper(Str::random(8)); 
        $data = $request->all();
        $data['password'] = Hash::make($defaultPassword);
        // $roleId = $request->role;
        $hospitalId = $request->hospital;

        // Extract user details
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone = $request->phoneNumber; // User's phone number

        // Query the hospital name using the hospitalId
        $hospital = Hospital::find($hospitalId);
        $hospitalName = $hospital->hospitalName;
        $hospitalShortName = $hospital->hospitalShortName;

        // Query the role name using the roleId
        // $roleName = "Hospital Admin";
        // $role = Roles::where('roleName', 'like', "%$roleName%")->first();

        
        $role = Roles::where('roleId', '=', "7")->first();
        $data['role'] = $role->roleId;
        $roleName = $role->roleName;
        // Create user
        $user = User::create($data);
        
        $staff['hospitalId'] = $hospitalId;
        $staff['userId'] = $user->id;
        if($hospital){
            HospitalStaff::create($staff);
        }
        $user->load('hospital_admins.hospital'); 

        // Send welcome email with the role and hospital names
        Mail::to($email)->send(new AdminWelcomeEmail($email, $firstName, $lastName, $hospitalName, $roleName, $defaultPassword));

        // // Send SMS with the role and hospital names
        $smsMessage = "Hello $firstName, You have just been added as an $roleName at $hospitalShortName. Your temporary password is: $defaultPassword.";
        $this->sendSMS($phone, $smsMessage);

        return response()->json([
            'success' => true,
            'message' => "$roleName for $hospitalName has been added successfully. A welcome email and SMS notification have been sent.",
            'user' => $user
        ], 201);
        

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'User registration failed. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}

//  Patient Application Signup
public function patientSignUp(Request $request)
{
    try {
        // Check if email or phone number already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists. Please use a different email.'
            ], 400);
        }

        if (User::where('phoneNumber', $request->phoneNumber)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already exists. Please use a different phone number.'
            ], 400);
        }

        // Generate a random password
        $defaultPassword = strtoupper(Str::random(8)); 
        $data = $request->all();
        $data['password'] = Hash::make($defaultPassword);
        $data['role'] = 1; // Default role is patient

        // Extract user details
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone = $request->phoneNumber; // User's phone number

        // Get list of statuses
        $statusId = StatusList::orderBy('statusId')->value('statusId');

        // Create user
        $user = User::create($data);

        // Store application status
        $status_data = [
            'patientUserId' => $user->id,
            'reviewerId' => $user->id,
            'reviewerRole' => 1,
            'statusId' => 2
        ];
        ApplicationReview::create($status_data);

        // Queue the welcome email
        $languageId = $request->languageId;
        Mail::to($email)->queue(new WelcomeEmail($email, $firstName, $lastName, $defaultPassword, $languageId));

        // Prepare SMS message based on language
        $smsMessage = match ($languageId) {
            1 => "Hello $firstName, thanks for registering on Cancer Health Fund! Your temporary password is: $defaultPassword.", // English
            3 => "Salam $firstName, godiya muke da yin rijista a Cancer Health Fund! Kalmar sirri ta wucin gadi ita ce: $defaultPassword.", // Hausa
            2 => "Salaamu ale $firstName, ope wa fun iforukosile re lori Cancer Health Fund! Oro asina igba die re ni: $defaultPassword.", // Yoruba
            4 => "Ndewo $firstName, daalu maka ndebanye aha gi na Cancer Health Fund! Okwuntughe nwa oge gi bu: $defaultPassword.", // Igbo
            default => "Hello $firstName, thanks for registering on Cancer Health Fund! Your temporary password is: $defaultPassword."
        };

        // Queue SMS job
        Queue::push(new SendSMSJob($phone, $smsMessage));

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. A welcome email and WhatsApp notification have been queued.',
            'user' => $user
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'User registration failed. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}


/**
 * Function to send WhatsApp message using WAAPI
 */
// private function sendWhatsAppNotification22($phone, $firstName, $password)
// {
//     $apiToken = 'IH2pKE3vMFVHIqyCacnv9TAH6yKEWSuN8NAPAHvx48d850d7';
//     $instanceId = '42892'; // Replace with your actual instance ID
//     $message = "Hello $firstName, welcome to our platform! Your temporary password is: $password. Please log in and update your password.";

//     try {
//         $client = new \GuzzleHttp\Client();
//         $response = $client->request('POST', "https://waapi.app/api/v1/instances/$instanceId/sendMessage", [
//             'headers' => [
//                 'Authorization' => 'Bearer ' . $apiToken,
//                 'Accept' => 'application/json',
//                 'Content-Type' => 'application/json',
//             ],
//             'json' => [
//                 'to' => $phone,
//                 'message' => $message,
//             ]
//         ]);

//         $responseBody = json_decode($response->getBody(), true);
//         return $responseBody;

//     } catch (\Exception $e) {
//         \Log::error("WhatsApp message sending failed: " . $e->getMessage());
//     }
// }








// public function sendWhatsAppNotificationSMS()
// {
//     try {
//         $waAPI = new WaAPI();
//         $phone = '2348119172755';  // Change to actual recipient
//         $message = 'Hello there!';
        
//         $response = $waAPI->sendMessage($phone, $message);

//         return response()->json([
//             'status' => 'success',
//             'response' => $response
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }

 



public function updateUser(Request $request, $id)
{
    // Find the patient by ID
    $user = User::find($id);
    if (!$user) {
        return response()->json([
            'error' => 'User not found',
        ], 404); 
    }

    $data = $request->all();
    $user->update($data);

    return response()->json([
        'message' => 'User updated successfully',
        'data' => $user,
    ], 200); 
}


 // Delete User
public function deleteUser($id){
    $user = User::find($id);
if ($user) {
$user->delete();
}
return response()->json($user, 201);
}
    
}
