<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Doctors;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
   

    // use Illuminate\Http\Request;
    // use Illuminate\Support\Facades\Hash;
    // use Illuminate\Validation\ValidationException;
    // use App\Models\User;
    
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required', // Can be email or phone number
            'password' => 'required',
        ]);
    
        // Find user by email or phone number
        $user = User::where('email', $request->username)
                     ->orWhere('phoneNumber', $request->username)
                     ->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        // Create a Sanctum token
        $token = $user->createToken('auth-token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
    

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get authenticated user
    public function user(Request $request)
    {
        return response()->json($request->user());
    }



public function register(Request $request)
{
    // Set default password
    $default_password = strtoupper(Str::random(2)) . mt_rand(1000000000, 9999999999);

    // Create user
    $user = User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'phoneNumber' => $request->phoneNumber,
        'email' => $request->email,
        'password' => Hash::make($default_password),
        'role' => $request->role,
    ]);

    Log::info('User created:', ['email' => $user->email]);

    // Send email
    try {
        Mail::to($user->email)->send(new WelcomeEmail($user->firstName, $user->lastName, $user->email, $default_password));
        Log::info('Email sent successfully to ' . $user->email);
    } catch (\Exception $e) {
        Log::error('Email sending failed: ' . $e->getMessage());
    }

    // Return response
    return response()->json([
        'message' => "User successfully created",
    ]);
}


    public function changePassword(Request $request)
{
    // Validate input
    $request->validate([
        'currentPassword' => 'required',
        'newPassword' => 'required|min:6', // 'confirmed' ensures newPassword_confirmation is also sent
    ]);

    $user = Auth::user();

    // Check if the current password matches
    if (!Hash::check($request->currentPassword, $user->password)) {
        return response()->json(['message' => 'Current password is incorrect.'], 422);
    }

    // // Only update the fields if they are provided
    // if ($request->has('email')) {
    //     $user->email = $request->email;
    // }
    // if ($request->has('phoneNumber')) {
    //     $user->phoneNumber = $request->phoneNumber;
    // }
    // if ($request->has('firstName')) {
    //     $user->firstName = $request->firstName;
    // }
    // if ($request->has('lastName')) {
    //     $user->lastName = $request->lastName;
    // }

    // Update the user's password
    $user->password = Hash::make($request->newPassword);
    $user->save();

    return response()->json(['message' => 'Password changed successfully.']);
}



public function updateProfile(Request $request)
{
    // Find the patient by ID
    $user = User::where('email', $request->email)->first();

    
    if (!$user) {
        return response()->json([
            'error' => 'User not found',
        ], 404); // HTTP status code 404: Not Found
    }

    
    $data = $request->all();

    
    $user->update($data);

    
    return response()->json([
        'message' => 'User updated successfully',
        'data' => $user,
    ], 200); // HTTP status code 200: OK
}
    
}
