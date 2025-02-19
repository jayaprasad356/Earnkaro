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

        // Update the status of the selected works
        Works::whereIn('id', $request->works_ids)->update(['status' => $status]);

        // Return the response with a success message
        return redirect()->route('works.index')->with('success', 'Works status updated successfully.');
    }

  
}
