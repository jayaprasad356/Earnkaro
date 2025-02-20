<?php

namespace App\Http\Controllers;

use App\Models\Works;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorksController extends Controller
{
    // Show Works List Page
    public function index()
    {
        $works = Works::all(); // Fetch works data
        $works = Works::with('user')->get();
        $news = News::latest()->first(); // Fetch the latest news record
        return view('works.index', compact('works', 'news'));
    }

    // Handle Image Upload
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        // Get user_id from session instead of auth()
        $userId = session('user_id');
    
        if (!$userId) {
            return back()->with('error', 'User ID not found. Please log in again.');
        }
    
        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('works', 'public');
        } else {
            return back()->with('error', 'Image upload failed.');
        }
    
        // Insert into works table
        Works::create([
            'user_id' => $userId,
            'status' => 0,
            'image' => $imagePath
        ]);
    
        return back()->with('success', 'Image uploaded successfully.');
    }
    
}
