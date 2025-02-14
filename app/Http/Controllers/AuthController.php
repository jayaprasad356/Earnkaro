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
            'd' => 'd_referred_by'
        ];
        
        $column = $columnMap[$level] ?? null;
    
        if (!$column) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid level',
            ], 400);
        }
    
        // Fetch referred users
        $users = DB::table('users')
            ->where($column, $refer_code)
            ->orderBy('id', 'desc')
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
    
}