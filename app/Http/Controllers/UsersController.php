<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;
class UsersController extends Controller
{
    public function RetrieveAll()
    {
        $users = Users::with('role')->get();
        return response()->json($users, 201); 
       
    }


    public function clinic_receptionists()
    {
        $users = Users::with('role')
        ->where('role', '=', '2')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function front_desk()
    {
        $users = Users::with('role')
        ->where('role', '=', '3')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function doctors()
    {
        $users = Users::with('role')
        ->where('role', '=', '4')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function workshop_receptionists()
    {
        $users = Users::with('role')
        ->where('role', '=', '5')
        ->get();
        return response()->json($users, 201); 
       
    }

    public function nurses()
    {
        $users = Users::with('role')
        ->where('role', '=', '6')
        ->get();
        return response()->json($users, 201); 
       
    }
    
    public function store(Request $request)
{
    $defaultPassword = strtoupper(Str::random(8)); // Generate a random password
    $data = $request->all();
    $password = Hash::make($defaultPassword);
    $data['password'] = $password;
    
    $firstName = $request->firstName;
    $lastName = $request->lastName;
    $email = $request->email;

    $user = Users::create($data); 

    Mail::to($request->email)->send(new WelcomeEmail($email, $firstName, $lastName, $defaultPassword));
    // try {
    //     Log::info('Email sent successfully to ' . $user->email);
    // } catch (\Exception $e) {
    //     Log::error('Email sending failed: ' . $e->getMessage());
    // }

    return response()->json($user, 201); 
   
}



public function updateUser(Request $request, $id)
{
    // Find the patient by ID
    $user = Users::find($id);
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
    $user = Users::find($id);
if ($user) {
$user->delete();
}
return response()->json($user, 201);
}
    
}
