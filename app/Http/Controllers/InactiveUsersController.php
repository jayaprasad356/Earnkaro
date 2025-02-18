<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InactiveUsersController extends Controller
{
    public function index()
    {
        // Get user_id from session
        $user_id = Session::get('user_id');
    
        // Fetch the user and their balance from the database
        $user = Users::find($user_id);
    
        // If user is found, get their balance, else default to 0
        $balance = $user ? $user->balance : 0;
    
        // Fetch inactive users with status 0 from the database
        $users = Users::where('status', 0)->get();
    
        // Return the view with users and the balance value
        return view('inactive_users.index', compact('users', 'balance'));
    }

    public function activate(Request $request)
    {
        // Get the logged-in user's user_id from session
        $user_id = Session::get('user_id');
        
        // Fetch the logged-in user from the database
        $user = Users::find($user_id);
        
        // If user is found, get their balance, else default to 0
        $balance = $user ? $user->balance : 0;
        
        // Get the user details (id, name, mobile, level) from the query parameters
        $id = $request->query('id');  // use 'id' instead of 'userId'
        $userName = $request->query('name');
        $userMobile = $request->query('mobile');
        $level = $request->query('level');
        
        // Return the activation view with the user details, level, and balance
        return view('inactive_users.activate', compact('user', 'id', 'userName', 'userMobile', 'level', 'balance'));
    }

    public function activateusers(Request $request)
    {
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $balance = $user ? $user->balance : 0;
    
        // Get the user details (id, name, mobile, level) from the query parameters
        $id = $request->query('id');
        $userName = $request->query('name');
        $userMobile = $request->query('mobile');
        $level = $request->query('level');
    
        // If level is 1, check if the user has activated 3 users already
        if ($level == 1) {
            // Count how many level 1 users have been activated by the current user (user_id)
            $referralCount = Users::where('referred_by', $user_id)->count();
    
            // If there are already 3 referrals for Level 1, don't allow activation
            if ($referralCount >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already activated 3 users for Level 1.'
                ]);
            }
    
            // Proceed with the activation if less than 3 users
            // Activate the selected user (update their status)
            $selectedUser = Users::find($id);
            if ($selectedUser) {
                $selectedUser->status = 1; // Update user status to active
                $selectedUser->referred_by = $user_id;  // Set the referring user ID
                $selectedUser->save();
    
                // Insert a transaction record for the activation
                DB::table('transactions')->insert([
                    'user_id' => $user_id,
                    'referred_user_id' => $id,
                    'type' => 'level_1_activate',
                    'amount' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'User activated successfully for Level 1.'
                ]);
            }
    
            // If selected user doesn't exist
            return response()->json([
                'success' => false,
                'message' => 'Selected user does not exist.'
            ]);
        }
    
        // Logic for other levels can go here (if necessary)
    }
    


  
    public function getLevelUsers(Request $request)
    {
        $userId = $request->input('user_id');
        $level = $request->input('level');
    
        // Map levels to their corresponding names (Level C, D, E)
        $levelMapping = [
            2 => 'c',  // Level 2 => Level C
            3 => 'd',  // Level 3 => Level D
            4 => 'e'   // Level 4 => Level E
        ];
    
        $mappedLevel = isset($levelMapping[$level]) ? $levelMapping[$level] : null;
    
        if (!$mappedLevel) {
            return response()->json(['error' => 'Invalid level'], 400);
        }
    
        // Log the user ID and level before making the API call
        Log::info("Fetching users for user_id: $userId, level: $mappedLevel");
    
        // Call the API to fetch the users based on the user_id and level
        try {
            $response = Http::post('http://localhost/Earnkaro/api/level', [
                'user_id' => $userId,
                'level' => $mappedLevel  // Use mapped level
            ]);
        } catch (\Exception $e) {
            // Log the error if the API call fails
            Log::error('Failed to call API: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch users.'], 500);
        }
    
        $data = $response->json(); // Convert API response to an array
    
        if (!$data['success']) {
            // Log the failed response
            Log::error('API Response Error: ' . json_encode($data));
            return response()->json(['error' => 'Failed to fetch users.'], 500);
        }
    
        // Return the data to the frontend
        return response()->json([
            'data' => $data['data'] // Assuming the 'data' key contains the user list
        ]);
    }
    
    public function addusers()
{
    $user_id = Session::get('user_id');  // Get the logged-in user's ID from session
    $user = Users::find($user_id);  // Fetch the user from the database

    if (!$user) {
        return redirect()->route('inactive_users.index')->with('error', 'User not found.');
    }

    $refer_code = $user->refer_code;  // Get the refer_code of the logged-in user

    return view('inactive_users.addusers', compact('refer_code'));
}

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'age' => 'required|integer|min:18', // Assuming age should be an integer and at least 18
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);
    
        // Get the logged-in user's information from session
        $user_id = Session::get('user_id');
        
        // Fetch the user's refer_code from the database using the user_id from session
        $user = Users::find($user_id);  // Assuming you have a User model and the user exists in the database
    
        if (!$user) {
            return redirect()->route('inactive_users.addusers')->with('error', 'User not found.');
        }
    
        $refer_code = $user->refer_code;  // Assuming 'refer_code' is a column in the 'users' table
    
        // API endpoint to register the user
        $apiUrl = 'https://earnkaro.graymatterworks.com/api/register';  // Replace with your actual registration API URL
    
        // Prepare the data to send to the API
        $apiData = [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'],
            'password' => $validated['password'],  // Encrypt the password
            'age' => $validated['age'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'referred_by' => $refer_code, // Automatically use the logged-in user's refer_code from session
        ];
    
        // Make the API request (you can also use other libraries like Guzzle if needed)
        $response = Http::post($apiUrl, $apiData);
    
        // Check if the registration was successful
        if ($response->successful()) {
            return redirect()->route('inactive_users.index')->with('success', 'User registered successfully.');
        } else {
            // Handle API error
            return redirect()->route('inactive_users.addusers')->with('error', 'Registration failed. Please try again.');
        }
    }
    
    
}
    

    



