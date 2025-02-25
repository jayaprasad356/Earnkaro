<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Works;
use Illuminate\Http\Request;
use App\Exports\WithdrawalsExport; 
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class WorksController extends Controller
{
    public function index(Request $request)
    {
        // Get the filters from the query string
        $status = $request->get('status'); // Default to Pending
        $transferType = $request->get('transfer_type'); // No default
        $filterDate = $request->get('filter_date');

        // Query to fetch withdrawals based on the filters
        $works = Works::with('users')
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($transferType, function ($query) use ($transferType) {
                return $query->where('type', $transferType); // Assuming 'type' is the column for transfer type
            })
            ->when($filterDate, function ($query) use ($filterDate) {
                return $query->whereDate('datetime', $filterDate); // Filter withdrawals by selected date
            })
            ->when($request->get('search'), function ($query, $search) {
                $query->where('transaction_id', 'like', '%' . $search . '%')
                      ->orWhereHas('users', function ($query) use ($search) {
                          $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('mobile', 'like', '%' . $search . '%');
                      });
            })
            ->orderBy('datetime', 'desc') // Order by latest data
            ->get();

        // Return the view with the filtered withdrawals
        return view('works.index', compact('works'));
    }

    public function bulkUpdateStatus(Request $request)
    {
        // Validate the request to ensure work IDs and status are provided
        $request->validate([
            'works_ids' => 'required|array',
            'works_ids.*' => 'exists:works,id',
            'new_status' => 'required|integer|in:1,2', // Only allow 1 (Paid) or 2 (Cancelled)
        ]);
    
        $status = (int) $request->new_status;
    
        // Fetch works with user details
        $works = Works::whereIn('id', $request->works_ids)->with('users')->get();
    
        foreach ($works as $work) {
            // Prevent status change from 1 to 2 or 2 to 1
            if (($work->status == 2 && $status == 1)) {
                return redirect()->route('works.index')->with('success', 'Cannot Change into Verified work that is already marked as Cancelled.');
            }
    
            $user = $work->users;
    
            if ($user && $status === 1) { // Check only if verifying (setting status to 1)
                // Check if the user has already been verified today
                $alreadyVerified = DB::table('transactions')
                    ->where('user_id', $user->id)
                    ->where('type', 'whatsapp_status_income')
                    ->whereDate('datetime', now()->toDateString())
                    ->exists();
    
                if ($alreadyVerified) {
                    return redirect()->route('works.index')->with('error', 'User has already been verified today.');
                }
            }
        }
    
        // Update the status of the selected works
        Works::whereIn('id', $request->works_ids)->update(['status' => $status]);
    
        if ($status === 1) {
            // Fetch the latest or first available whatsapp_status_income from the news table
            $newsData = DB::table('news')->latest()->first(); // Get the latest record
            $amount = $newsData->whatsapp_status_income ?? 0; // Default to 0 if not found
    
            foreach ($works as $work) {
                $user = $work->users;
    
                if ($user) { // Ensure user exists
                    // Insert into transactions table
                    DB::table('transactions')->insert([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'type' => 'whatsapp_status_income',
                        'datetime' => now(),
                    ]);
    
                    // Update user's whatsapp_status_income and refer_income fields
                    $user->increment('whatsapp_status_income', $amount);
                }
            }
        }
    
        // Return the response with a success message
        return redirect()->route('works.index')->with('success', 'Works status updated successfully.');
    }
    
}
