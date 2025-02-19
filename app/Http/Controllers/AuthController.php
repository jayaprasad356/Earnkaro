<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Upis;
use App\Models\Avatars;
use App\Models\Coins;
use App\Models\SpeechText;  
use App\Models\Appsettings; 
use App\Models\Ratings; 
use App\Models\Gifts;
use App\Models\Transactions;
use App\Models\DeletedUsers; 
use App\Models\Withdrawals;  
use App\Models\UserCalls;
use App\Models\explaination_video;
use App\Models\explaination_video_links;
use Carbon\Carbon;
use App\Models\News; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function level(Request $request)
    {
        $user_id = $request->input('user_id');
        $level = $request->input('level');
    
        if (empty($user_id)) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is empty',
            ], 400);
        }
    
        if (empty($level)) {
            return response()->json([
                'success' => false,
                'message' => 'Level is empty',
            ], 400);
        }
    
        // Fetch user refer_code
        $user = DB::table('users')->where('id', $user_id)->select('refer_code')->first();
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User Not found',
            ], 404);
        }
    
        $refer_code = $user->refer_code;
        $columnMap = [
            'b' => 'referred_by',
            'c' => 'c_referred_by',
            'd' => 'd_referred_by',
            'e' => 'e_referred_by'
        ];
        
        $column = $columnMap[$level] ?? null;
    
        if (!$column) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid level',
            ], 400);
        }
    
        // Fetch referred users with status 0
        $users = DB::table('users')
        ->where($column, $refer_code)
        ->where('status', 0)
        ->orderBy('id', 'desc')
        ->select('*', DB::raw("DATE(registered_datetime) AS registered_date"))
        ->get();
    
    
        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No users found',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Users Listed Successfully',
            'count' => $users->count(),
            'data' => $users,
        ], 200);
    }
    



    public function register(Request $request)
   {
    // Check if all required parameters are provided
    $name = $request->input('name');
    $mobile = $request->input('mobile');
    $age = $request->input('age');
    $pincode = $request->input('pincode');
    $gender = $request->input('gender');
    $email = $request->input('email');
    $state = $request->input('state');
    $password = $request->input('password');
    $referred_by = $request->input('referred_by');

    if (empty($name)) {
        return response()->json(['success' => false, 'message' => "Name is Empty"]);
    }
    if (empty($mobile)) {
        return response()->json(['success' => false, 'message' => "Mobile number is Empty"]);
    }

    // Clean mobile number
    $mobileNumber = preg_replace('/[^0-9]/', '', $mobile);

    if (substr($mobileNumber, 0, 1) === '0') {
        return response()->json(['success' => false, 'message' => "Mobile number cannot start with '0'"]);
    }

    if (strlen($mobileNumber) !== 10) {
        return response()->json(['success' => false, 'message' => "Mobile number should be exactly 10 digits"]);
    }

    if (empty($age)) {
        return response()->json(['success' => false, 'message' => "Age is Empty"]);
    }
    if (empty($pincode)) {
        return response()->json(['success' => false, 'message' => "pincode is Empty"]);
    }
    if (empty($email)) {
        return response()->json(['success' => false, 'message' => "Email is Empty"]);
    }
    if (empty($state)) {
        return response()->json(['success' => false, 'message' => "State is Empty"]);
    }
    if (empty($password)) {
        return response()->json(['success' => false, 'message' => "Password is Empty"]);
    }
    if (empty($gender)) {
        return response()->json(['success' => false, 'message' => "gender is Empty"]);
    }
    if (empty($referred_by)) {
        return response()->json(['success' => false, 'message' => "Referred By is Empty"]);
    }

     // Check if referred_by is valid
     if ($referred_by !== '5PL') {
        $referrer = Users::where('refer_code', $referred_by)->first();
        if (!$referrer) { return response()->json(['success' => false, 'message' => "Invalid Referred By"]); }
    }

    // Check if mobile is already registered
    $existingUser = Users::where('mobile', $mobile)->first();
    if ($existingUser) { return response()->json(['success' => false, 'message' => "Mobile Number Already Registered"]); }

    // Handling referred_by logic for deeper referrals (4 levels)
    $c_referred_by = '';
    $d_referred_by = '';
    $e_referred_by = '';

     // If the referred_by is not '5PL' (which means there's a valid refer_code)
     if ($referred_by !== '5PL') {
        // Step 1: Find ref1 (First level, c_referred_by)
        $ref1 = Users::where('refer_code', $referred_by)->first();
        if ($ref1) {
            $c_referred_by = $ref1->referred_by;

            // Step 2: Find ref2 (Second level, d_referred_by)
            if ($c_referred_by) {
                $ref2 = Users::where('refer_code', $c_referred_by)->first();
                if ($ref2) {
                    $d_referred_by = $ref2->referred_by;
                    
                    // Step 3: Find ref3 (Third level, e_referred_by)
                    if ($d_referred_by) {
                        $ref3 = Users::where('refer_code', $d_referred_by)->first();
                        if ($ref3) {
                            $e_referred_by = $ref3->referred_by;
                        }
                    }
                }
            }
        }
    }

    // Insert user data
    $user = new Users();
    $user->name = $name;
    $user->mobile = $mobile;
    $user->age = $age;
    $user->pincode = $pincode;
    $user->gender = $gender;
    $user->email = $email;
    $user->state = $state;
    $user->password = $password;
    $user->referred_by = $referred_by;
    $user->c_referred_by = $c_referred_by;
    $user->d_referred_by = $d_referred_by;
    $user->e_referred_by = $e_referred_by; // Added e_referred_by
    $user->registered_datetime = Carbon::now();
    $user->monthly_salary = 25000;
    $user->save();

    // Generate refer code
    $refer_code = 'PL' . str_pad($user->id, 2, '0', STR_PAD_LEFT);
    $user->refer_code = $refer_code;
    $user->save();

    return $user;
}
public function updateBankDetails(Request $request)
{
    $user_id = $request->input('user_id');
    $account_num = $request->input('account_num');
    $holder_name = $request->input('holder_name');
    $bank = $request->input('bank');
    $branch = $request->input('branch');
    $ifsc = $request->input('ifsc');

    if (empty($user_id)) {
        return response()->json([
            'success' => false,
            'message' => 'User ID is empty',
        ], 400);
    }

    if (empty($account_num)) {
        return response()->json([
            'success' => false,
            'message' => 'Account number is empty',
        ], 400);
    }

    if (empty($holder_name)) {
        return response()->json([
            'success' => false,
            'message' => 'Holder name is empty',
        ], 400);
    }

    if (empty($bank)) {
        return response()->json([
            'success' => false,
            'message' => 'Bank is empty',
        ], 400);
    }

    if (empty($branch)) {
        return response()->json([
            'success' => false,
            'message' => 'Branch is empty',
        ], 400);
    }

    if (empty($ifsc)) {
        return response()->json([
            'success' => false,
            'message' => 'IFSC is empty',
        ], 400);
    }

    $user = Users::find($user_id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User Not found',
        ], 404);
    }

    if (!empty($user->account_num) || !empty($user->holder_name) || !empty($user->bank) || !empty($user->branch) || !empty($user->ifsc)) {
        return response()->json([
            'success' => false,
            'message' => 'Bank details have already been updated and cannot be changed again.',
        ], 400);
    }

    $user->update([
        'account_num' => $account_num,
        'holder_name' => $holder_name,
        'bank' => $bank,
        'branch' => $branch,
        'ifsc' => $ifsc,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Bank Details Updated Successfully',
        'data' => $user,
    ], 200);
 }
}
