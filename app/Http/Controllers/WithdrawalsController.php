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
        $bank = $user->bank ?? ''; // Fetching bank details
        $branch = $user->branch ?? '';
        $ifsc = $user->ifsc ?? '';
        $account_num = $user->account_num ?? '';
        $holder_name = $user->holder_name ?? '';
        
        // Pass data to the view
        return view('withdrawals.show', compact('earningWallet', 'bonusWallet', 'balance', 'bank', 'branch', 'ifsc', 'account_num', 'holder_name'));
    }
    
   
    public function addToMainBalance(Request $request)
    {
        // Check if user_id exists in session
        $user_id = session()->get('user_id');
        
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 403); // Unauthorized access
        }
    
        // Get wallet type and amount from request
        $walletType = $request->input('wallet_type');
        $datetime = now();
    
        // Retrieve user data
        $user = Users::find($user_id);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404); // User not found
        }
    
        
        // Based on wallet type, perform the corresponding action
        if ($walletType == 'earning_wallet') {
            // Fetch the current earning wallet balance
            $earningWalletBalance = $user->earning_wallet;
       
            if ($walletType == 'earning_wallet' && $earningWalletBalance < 10) {
                return response()->json([
                    'success' => false,
                    'message' => "Minimum 10 rs to add from Earning Wallet.",
                ], 400); // Minimum amount check for earning wallet
            }
        
            if ($earningWalletBalance) {
                // Proceed to update the earning wallet and main balance
                DB::beginTransaction();
                try {
                    // Record the transaction
                    Transactions::create([
                        'user_id' => $user_id,
                        'type' => 'earning_wallet',
                        'datetime' => $datetime,
                        'amount' => $earningWalletBalance,
                    ]);
    
                    // Update user balances
                    $user->earning_wallet -= $earningWalletBalance;
                    $user->balance += $earningWalletBalance;
                    $user->save();
    
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Amount successfully added to main balance from Earning Wallet.',
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred. Please try again.',
                    ], 500);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance in Earning Wallet.',
                ], 400); // Insufficient funds in earning wallet
            }
        } elseif ($walletType == 'bonus_wallet') {
            // Fetch the current bonus wallet balance
            $bonusWalletBalance = $user->bonus_wallet;
    
            if ($walletType == 'bonus_wallet' && $bonusWalletBalance < 50) {
                return response()->json([
                    'success' => false,
                    'message' => "Minimum 50 rs to add from Bonus Wallet.",
                ], 400); // Minimum amount check for bonus wallet
            }

            if ($bonusWalletBalance) {
                // Proceed to update the bonus wallet and main balance
                DB::beginTransaction();
                try {
                    // Record the transaction
                    Transactions::create([
                        'user_id' => $user_id,
                        'type' => 'bonus_wallet',
                        'datetime' => $datetime,
                        'amount' => $bonusWalletBalance,
                    ]);
    
                    // Update user balances
                    $user->bonus_wallet -= $bonusWalletBalance;
                    $user->balance += $bonusWalletBalance;
                    $user->save();
    
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Amount successfully added to main balance from Bonus Wallet.',
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred. Please try again.',
                    ], 500);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance in Bonus Wallet.',
                ], 400); // Insufficient funds in bonus wallet
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid wallet type.',
            ], 400); // Invalid wallet type
        }
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
    
        // Check if current time is between 10:00 AM and 6:00 PM
        if (!$this->isBetween10AMand6PM()) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal time is between 10:00 AM and 6:00 PM.',
            ], 400); // Time restriction
        }
    
        // Check if today is a weekend (Sunday or Saturday)
        $dayOfWeek = date('w'); // 0 = Sunday, 6 = Saturday
        if ($dayOfWeek == 0 || $dayOfWeek == 7) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawals are allowed only from Monday to Saturday.',
            ], 400); // Day restriction
        }
    
        // Get the withdrawal details from the request
        $amount = $request->input('amount');
        $holderName = $request->input('holder_name');
        $accountNumber = $request->input('account_number');
        $bank = $request->input('bank');
        $branch = $request->input('branch');
        $ifsc = $request->input('ifsc');
    
        // Retrieve user details
        $user = Users::find($user_id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404); // User not found
        }
    
        // Check if withdrawal is disabled for this user
        if ($user->withdrawal_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawals are disabled for your account.',
            ], 400); // Withdrawal disabled
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
    
        // Retrieve system settings (min_withdrawal and withdrawal_status)
        $settings = DB::table('settings')->where('id', 1)->first();
        
        if (!$settings || $settings->withdrawal_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal functionality is currently disabled.',
            ], 400); // Withdrawal disabled in settings
        }
    
        // Validate minimum withdrawal amount
        $min_withdrawal = $settings->min_withdrawal;
        if ($amount < $min_withdrawal) {
            return response()->json([
                'success' => false,
                'message' => "Minimum withdrawal amount is $min_withdrawal.",
            ], 400); // Withdrawal amount is less than the minimum required
        }
    
        // Validate amount
        if ($amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid withdrawal amount.',
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
    
            // Update or Insert Bank Details into the users table
            $user->update([
                'holder_name' => $holderName,
                'account_number' => $accountNumber,
                'bank' => $bank,
                'branch' => $branch,
                'ifsc' => $ifsc,
            ]);
    
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
    
    // Helper function to check if current time is between 10:00 AM and 6:00 PM
    private function isBetween10AMand6PM() {
        $currentHour = date('H');
        $startTimestamp = strtotime('10:00:00');
        $endTimestamp = strtotime('18:00:00');
        return ($currentHour >= date('H', $startTimestamp)) && ($currentHour < date('H', $endTimestamp));
    }
    

    
}
