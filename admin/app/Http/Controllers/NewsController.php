<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function edit()
    {
        $news = News::findOrFail(1); // Assuming you're always editing the record with ID 1
        return view('news.edit', compact('news'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'telegram_link' => 'required|string',
            'customer_support_number' => 'required|string',
            'minimum_withdrawals' => 'required|string',
            'whatsapp_status_income' => 'required|string',
            'download_today_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $news = News::findOrFail(1);
    
        if ($request->hasFile('download_today_image')) {
            $imagePath = $request->file('download_today_image')->store('news', 'public');
            $news->download_today_image = $imagePath;
        }
    
        $news->update($request->except(['download_today_image']));
    
        return redirect()->route('news.edit')->with('success', 'Settings updated successfully.');
    }
    
}
