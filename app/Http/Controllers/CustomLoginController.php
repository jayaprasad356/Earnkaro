<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Session;

class CustomLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.mobile-login');
    }

    public function login(Request $request)
{
    // Validate input
    $request->validate([
        'mobile' => 'required|exists:users,mobile',
        'password' => 'required',
    ]);

    // Find user by mobile number
    $user = Users::where('mobile', $request->mobile)->first();

    // Check user existence and manually verify password (without hashing)
    if ($user) {
        if ($user->status == 0) {
            return back()->withErrors(['mobile' => 'Your account is not activated.'])->withInput();
        }

        if ($user->status == 2) {
            return back()->withErrors(['mobile' => 'Your account has been rejected.'])->withInput();
        }

        if ($request->password === $user->password) {
            // Store user details in session
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            return redirect()->route('dashboard')->with('success', 'Login successful');
        }
    }

    return back()->withErrors(['mobile' => 'Invalid credentials'])->withInput();
}

    public function logout()
    {
        Session::forget('user_id'); 
        Session::forget('user_name'); 

        return redirect()->route('mobile.login')->with('success', 'Logged out successfully');
    }
}
