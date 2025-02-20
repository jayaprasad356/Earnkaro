<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        // Get the user ID from session
        $userId = session('user_id');
    
        if (!$userId) {
            return back()->with('error', 'User not found. Please log in again.');
        }
    
        // Get distinct transaction types for the dropdown
        $types = Transactions::where('user_id', $userId)->select('type')->distinct()->pluck('type');
    
        // Apply filters based on session user_id and selected filters
        $transactions = Transactions::with('users') // Ensure user relation is loaded
            ->where('user_id', $userId) // Filter by session user ID
            ->when($request->get('filter_date'), function ($query, $filterDate) {
                return $query->whereDate('datetime', $filterDate); // Filter by date
            })
            ->when($request->input('type'), function ($query, $type) {
                return $query->where('type', $type); // Filter by type
            })
            ->orderBy('datetime', 'desc') // Order by latest data
            ->get();
    
        return view('transactions.index', compact('transactions', 'types'));
    }
    
}
