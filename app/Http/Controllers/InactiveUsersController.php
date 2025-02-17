<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Users;
use Illuminate\Support\Facades\Log;

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

    public function showActivationPage(Request $request)
    {
        $level = $request->input('level'); // Level 2, 3, or 4
        $users = Users::where('status', 0)->limit(10)->get(); // Fetch 10 inactive users
        $balance = auth()->user()->balance; // Assuming you have a balance attribute in the user model
        
        // Return the view with level, users, and balance data
        return view('inactive_users.activate', compact('level', 'users', 'balance'));
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
            $response = Http::post('https://earnkaro.graymatterworks.com/api/level', [
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
    
    
}
    



