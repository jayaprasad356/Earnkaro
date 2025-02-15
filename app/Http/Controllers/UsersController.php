<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function level1List()
    {
        // Get user_id from session
        $user_id = Session::get('user_id');

        // Check if user_id exists
        if (!$user_id) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
        }

        // Call the API to get level data
        $response = Http::post('https://earnkaro.graymatterworks.com/api/level', [
            'user_id' => $user_id,
            'level' => 'b'
        ]);

        // Convert response to array
        $data = $response->json();

        // Check if API call was successful
        if (!$data['success']) {
            return redirect()->back()->withErrors(['error' => 'Failed to fetch data.']);
        }

        // Pass data to view
        return view('level_1.index', [
            'user_id' => $user_id,
            'users' => $data['data'] // Assuming the API returns 'data' as an array
        ]);
    }

    public function level2List()
    {
        // Get user_id from session
        $user_id = Session::get('user_id');

        // Check if user_id exists
        if (!$user_id) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
        }

        // Call the API to get level data
        $response = Http::post('https://earnkaro.graymatterworks.com/api/level', [
            'user_id' => $user_id,
            'level' => 'c'
        ]);

        // Convert response to array
        $data = $response->json();

        // Check if API call was successful
        if (!$data['success']) {
            return redirect()->back()->withErrors(['error' => 'Failed to fetch data.']);
        }

        // Pass data to view
        return view('level_2.index', [
            'user_id' => $user_id,
            'users' => $data['data'] // Assuming the API returns 'data' as an array
        ]);
    }

    public function level3List()
    {
        // Get user_id from session
        $user_id = Session::get('user_id');

        // Check if user_id exists
        if (!$user_id) {
            return redirect()->route('mobile.login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
        }

        // Call the API to get level data
        $response = Http::post('https://earnkaro.graymatterworks.com/api/level', [
            'user_id' => $user_id,
            'level' => 'd'
        ]);

        // Convert response to array
        $data = $response->json();

        // Check if API call was successful
        if (!$data['success']) {
            return redirect()->back()->withErrors(['error' => 'Failed to fetch data.']);
        }

        // Pass data to view
        return view('level_3.index', [
            'user_id' => $user_id,
            'users' => $data['data'] // Assuming the API returns 'data' as an array
        ]);
    }
}
