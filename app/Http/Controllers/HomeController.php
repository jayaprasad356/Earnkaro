<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use App\Models\Announcement;
use App\Models\AttendanceEmployee;
use App\Models\Employee;
use App\Models\Event;
use App\Models\LandingPageSection;
use App\Models\Meeting;
use App\Models\Job;
use App\Models\Order;
use App\Models\Payees;
use App\Models\Avatars;
use App\Models\Users;
use App\Models\UserCalls;
use App\Models\Withdrawals;
use App\Models\Payer;
use App\Models\Plan;
use App\Models\Ticket;
use App\Models\Admin;
use App\Models\Transactions;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userId = session('user_id'); // Get user_id from session
    
        if (!$userId) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access']);
        }
    
        // Fetch user details
        $user = Users::where('id', $userId)->first();
    
        // Fetch financial details (modify according to your database structure)
        $total_income = $user->total_income ?? 0;
        $balance = $user->balance ?? 0; // User balance
        $recharge_value = $user->recharge ?? 0;
    
        return view('dashboard.dashboard', compact('total_income', 'balance', 'recharge_value'));
    }
    

}

    

