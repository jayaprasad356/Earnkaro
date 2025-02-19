<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Users; // Import User model

class BankDetailsController extends Controller
{
    public function showUpdateForm()
    {
        // Get user_id from session
        $user_id = Session::get('user_id');

        // Check if user_id exists
        if (!$user_id) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
        }

        // Fetch user details from users table
        $user = Users::where('id', $user_id)->first();

        // Check if user exists
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found.']);
        }

        // Pass user data to the view
        return view('bankdetails.update', compact('user'));
    }

    public function update(Request $request)
    {
        // Get user_id from session
        $user_id = Session::get('user_id');

        // Check if user_id exists
        if (!$user_id) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
        }

        // Prepare bank details from request
        $bankDetails = [
            'user_id'     => $user_id,
            'account_num' => $request->input('account_num'),
            'holder_name' => $request->input('holder_name'),
            'bank'        => $request->input('bank'),
            'branch'      => $request->input('branch'),
            'ifsc'        => $request->input('ifsc'),
        ];

        // Call the API to update bank details
        $response = Http::post('https://earnkaro.graymatterworks.com/api/updateBankDetails', $bankDetails);

        // Convert API response
        $data = $response->json();

        // Check API response and redirect accordingly
        if ($data['success'] ?? false) {
            return redirect()->back()->with('success', 'Bank details updated successfully.');
        } else {
            return redirect()->back()->withErrors(['error' => $data['message'] ?? 'Failed to update bank details.']);
        }
    }
}
