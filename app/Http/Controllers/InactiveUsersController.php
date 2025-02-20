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
        $recharge = $user ? $user->recharge : 0;
    
        // Fetch inactive users with status 0 and level_1_refer the session user's refer_code
        $users = Users::where('status', 0)
                      ->where('level_1_refer', $user->refer_code)
                      ->get();
    
        // Return the view with users and the balance value
        return view('inactive_users.index', compact('users', 'recharge'));
    }

    public function activate(Request $request)
    {
        // Get the logged-in user's user_id from session
        $user_id = Session::get('user_id');
        
        // Fetch the logged-in user from the database
        $user = Users::find($user_id);
        
        // If user is found, get their balance, else default to 0
        $recharge = $user ? $user->recharge : 0;
        
        // Get the user details (id, name, mobile, level) from the query parameters
        $id = $request->query('id');  // use 'id' instead of 'userId'
        $userName = $request->query('name');
        $userMobile = $request->query('mobile');
        $level = $request->query('level');
        
        // Return the activation view with the user details, level, and balance
        return view('inactive_users.activate', compact('user', 'id', 'userName', 'userMobile', 'level', 'recharge'));
    }
 
    public function activateusers(Request $request)
    {
        $user_id = Session::get('user_id');
        $sessionUser = Users::find($user_id);
    
        if (!$sessionUser) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.'
            ]);
        }
    
        if ($sessionUser->recharge < 299) {
            return response()->json([
                'success' => false,
                'message' => 'Your recharge balance is too low to activate a user.'
            ]);
        }
    
        $selectedUserId = $request->query('id');
        $selectedUser = Users::find($selectedUserId);
    
        if (!$selectedUser) {
            return response()->json([
                'success' => false,
                'message' => 'Selected user does not exist.'
            ]);
        }
        if($selectedUser->status == 1){
            return response()->json([
                'success' => false,
                'message' => 'User already activated.'
            ]);
        }
    
        DB::beginTransaction();
        try {
            $level = $request->query('level');
            $level1User = null;
            $addLevelIncome = false;
    
            // **Level 1 Activation Check**
            if ($level == 1) {
                $referralCount = Users::where('level_1_refer', $sessionUser->refer_code)
                                      ->where('status', 1)
                                      ->count();
                if ($referralCount >= 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only 3 members are allowed in Level 1.'
                    ]);
                }
            }
    
            // **Level 2 Activation Check**
            if ($level == 2) {
                $level1UserId = $request->query('level1_user_id');
                $level1User = Users::find($level1UserId);
    
                if (!$level1User) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected Level 1 user does not exist.'
                    ]);
                }
    
                $level1ReferralCount = Users::where('level_1_refer', $level1User->refer_code)->count();
                if ($level1ReferralCount >= 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This Level 1 user already has 3 referrals. Choose another user.'
                    ]);
                }
    
                // **Activate Level 1 user & add refer_income**
                $level1User->status = 1;
                $level1User->refer_income += 50;
                $level1User->save();
    
                $addLevelIncome = true;
            }
    
            // **Activate selected user**
            $selectedUser->status = 1;
            $selectedUser->save();
    
            // **Deduct balance from session user**
            $sessionUser->recharge -= 299;
    
            // **Only add level income for Level 2 activations**
            if ($addLevelIncome) {
                $sessionUser->level_income += 20;
            }
    
            $sessionUser->save();
    
    
            // **Log refer_income transaction for session user (Level 1 Activation)**
            if ($level == 1) {

                   // **Log transaction for selected user activation**
                DB::table('transactions')->insert([
                    'user_id' => $selectedUser->id,
                    'type' => 'level1_activation',
                    'amount' => 299,
                    'datetime' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('transactions')->insert([
                    'user_id' => $sessionUser->id,
                    'type' => 'refer_income',
                    'amount' => 50,
                    'datetime' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // **Log transactions for Level 2 Activation**
            if ($level == 2) {
                DB::table('transactions')->insert([
                    'user_id' => $level1User->id,
                    'type' => 'level2_activation',
                    'amount' => 299,
                    'datetime' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('transactions')->insert([
                    'user_id' => $level1User->id,
                    'type' => 'refer_income',
                    'amount' => 50,
                    'datetime' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                DB::table('transactions')->insert([
                    'user_id' => $sessionUser->id,
                    'type' => 'level_income',
                    'amount' => 20,
                    'datetime' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'User activated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
    
    
    public function getLevelUsers(Request $request)
    {
        $userId = Session::get('user_id');  // Get the logged-in user's ID from session
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
            $response = Http::post('https://greenkaro.jiyoapp.in/api/level', [
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
            'password' => 'required|string|min:8',
            'pincode' => 'required|string|min:6|max:6',
            'age' => 'required|integer|min:18', // Assuming age should be an integer and at least 18
            'gender' => 'required|string|max:255',
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
        $apiUrl = 'https://greenkaro.jiyoapp.in/api/register';  // Replace with your actual registration API URL
    
        // Prepare the data to send to the API
        $apiData = [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'password' => $validated['password'],  // Encrypt the password
            'pincode' => $validated['pincode'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'level_1_refer' => $refer_code, // Automatically use the logged-in user's refer_code from session
        ];
    
        // Make the API request (you can also use other libraries like Guzzle if needed)
        $response = Http::post($apiUrl, $apiData);
    
        // Check if the registration was successful
        $responseData = $response->json(); // Decode the JSON response

        if ($response->successful() && isset($responseData['success']) && $responseData['success'] === true) {
            return redirect()->route('inactive_users.index')->with('success', $responseData['message'] ?? 'User registered successfully.');
        } else {
            return redirect()->route('inactive_users.addusers')->with('error', $responseData['message'] ?? 'Registration failed. Please try again.');
        }
        
    }
    
    
}
    

    



