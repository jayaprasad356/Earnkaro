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
        $monthly_salery = $user->monthly_salery ?? 0;
        $level_income = $user->level_income ?? 0; // User balance
        $whatsapp_status_income = $user->whatsapp_status_income ?? 0;
        $refer_income = $user->refer_income ?? 0;
    
        return view('dashboard.dashboard', compact('monthly_salery', 'level_income', 'whatsapp_status_income','refer_income'));
    }
    

}

    

