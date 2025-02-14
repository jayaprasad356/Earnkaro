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

        // Manually verify password (without hashing)
        if ($user && $request->password === $user->password) {
            Session::put('user_id', $user->id); // Store user ID in session
            Session::put('user_name', $user->name); // Store user name (optional)

            return redirect()->route('dashboard')->with('success', 'Login successful');
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
