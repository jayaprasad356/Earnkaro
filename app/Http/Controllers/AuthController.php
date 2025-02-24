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
            'b' => 'level_1_refer',
            'c' => 'level_2_refer',
            'd' => 'level_3_refer',
            'e' => 'level_4_refer'
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
        ->where('status', 1)
        ->orderBy('registered_datetime', 'desc') // Order by registered_datetime in descending order
        ->select('*', DB::raw("DATE(registered_datetime) AS registered_date"), DB::raw("CONCAT(SUBSTRING(mobile, 1, 2), '******', SUBSTRING(mobile, LENGTH(mobile)-1, 2)) AS mobile"))
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
    $password = $request->input('password');
    $level_1_refer = $request->input('level_1_refer');

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
 
    if (empty($password)) {
        return response()->json(['success' => false, 'message' => "Password is Empty"]);
    }
    if (empty($gender)) {
        return response()->json(['success' => false, 'message' => "gender is Empty"]);
    }

    if (empty($level_1_refer)) {
        return response()->json(['success' => false, 'message' => "level_1_refer is Empty"]);
    }


    // Check if mobile is already registered
    $existingUser = Users::where('mobile', $mobile)->first();
    if ($existingUser) { return response()->json(['success' => false, 'message' => "Mobile Number Already Registered"]); }

  
    $level_2_refer = '';
    $level_3_refer = '';
    $level_4_refer = '';

    $ref1 = Users::where('refer_code', $level_1_refer)->first();
    if ($ref1) {
        $level_2_refer = $ref1->level_1_refer;
        if ($level_2_refer) {
            $ref2 = Users::where('refer_code', $level_2_refer)->first();
            if ($ref2) {
                $level_3_refer = $ref2->level_1_refer;
                if ($level_3_refer) {
                    $ref3 = Users::where('refer_code', $level_3_refer)->first();
                    if ($ref3) {
                        $level_4_refer = $ref3->level_1_refer;
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
    $user->password = $password;
    $user->level_1_refer = $level_1_refer;
    $user->level_2_refer = $level_2_refer;
    $user->level_3_refer = $level_3_refer;
    $user->level_4_refer = $level_4_refer; // Added e_referred_by
    $user->registered_datetime = Carbon::now();
    $user->monthly_salary = 25000;
    $user->save();

    // Generate refer code
    $refer_code = 'GK' . str_pad($user->id, 2, '0', STR_PAD_LEFT);
    $user->refer_code = $refer_code;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully',
        'data' => $user
    ], 200);
    
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
