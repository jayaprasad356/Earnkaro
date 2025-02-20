<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Withdrawals;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Exports\WithdrawalsExport; 
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawalsController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the user_id from session
        $user_id = session()->get('user_id');
    
        if (!$user_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    
        // Get filters from the request
        $status = $request->get('status');
        $filterDate = $request->get('filter_date');
    
        // Query withdrawals for the specific user
        $withdrawals = Withdrawals::with('users')
            ->where('user_id', $user_id) // Filter by session user ID
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($filterDate, function ($query) use ($filterDate) {
                return $query->whereDate('datetime', $filterDate);
            })
            ->orderBy('datetime', 'desc')
            ->get();
    
        // Return view with filtered withdrawals
        return view('withdrawals.index', compact('withdrawals'));
    }
    public function show()
    {
        $user_id = session()->get('user_id');
    
        if (!$user_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    
        // Fetch the user from the database
        $user = Users::find($user_id);
    
        // Get the bank details from the user record
        $earningWallet = $user->earning_wallet ?? 0;
        $bonusWallet = $user->bonus_wallet ?? 0;
        $balance = $user->balance ?? 0;
    
        // Fetch minimum withdrawal amount from the latest news record
        $news = \App\Models\News::latest()->first();
        $minimum_withdrawals = $news->minimum_withdrawals ?? ''; // Default to 100 if not set
    
        // Pass data to the view
        return view('withdrawals.show', compact(
            'earningWallet', 'bonusWallet', 'balance', 
             'minimum_withdrawals'
        ));
    }
    
       
   
    public function submitWithdrawal(Request $request)
    {
        // Check if user is logged in
        $user_id = session()->get('user_id');
        
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403); // Unauthorized access
        }
    
        // Get the withdrawal details from the request
        $amount = $request->input('amount');
    
        // Retrieve user details
        $user = Users::find($user_id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404); // User not found
        }

          // Check current day and time
            $currentDay = now()->format('l'); // Get the current day (e.g., Monday, Tuesday)
            $currentTime = now()->format('H:i'); // Get the current time in 24-hour format

            // Allowed days and time range
            $allowedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $startTime = '10:00';
            $endTime = '18:00';

            if (!in_array($currentDay, $allowedDays) || $currentTime < $startTime || $currentTime > $endTime) {
                return response()->json([
                    'success' => false,
                    'message' => 'Withdrawals are only allowed from Monday to Saturday between 10:00 AM and 6:00 PM.',
                ], 400);
            }
    
        if (!$user->holder_name || !$user->account_num || !$user->bank || !$user->branch || !$user->ifsc) {
            return response()->json([
                'success' => false,
                'message' => 'Bank details are missing. Please update them before withdrawing.',
            ], 400);
        }
    
        // Check for pending withdrawals
        $pendingWithdrawals = Withdrawals::where('user_id', $user_id)
                                         ->where('status', 0) // status = 0 indicates pending
                                         ->get();
        
        if ($pendingWithdrawals->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Please withdraw again after your pending withdrawal is paid.',
            ], 400); // Pending withdrawal exists
        }
    
     
    // Retrieve withdrawal settings from the "news" table instead of "settings"
        $news = DB::table('news')->where('id', 1)->first(); 

        if (!$news || $news->withdrawal_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal functionality is currently disabled.',
            ], 400); // Withdrawal disabled in settings
        }

        // Use the min_withdrawal from the "news" table
        $minimum_withdrawals = $news->minimum_withdrawals;


        // Validate amount
        if ($amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid withdrawal amount.',
            ], 400);
        }


        if ($amount < $minimum_withdrawals) {
            return response()->json([
                'success' => false,
                'message' => "Minimum withdrawal amount is $minimum_withdrawals.",
            ], 400);
        }
    
        // Check if user has enough balance
        if ($user->balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance.',
            ], 400); // Insufficient balance
        }
    
        // Proceed with withdrawal
        DB::beginTransaction();
        try {
            // Create a withdrawal record
            Withdrawals::create([
                'user_id' => $user_id,
                'amount' => $amount,
                'status' => 0, // Set status as 'pending'
                'datetime' => now(),
              
            ]);
    
            // Update user's balance
            $user->balance -= $amount;
            $user->save();
    
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Withdrawal request successfully submitted.',
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }
    
  
    
}
