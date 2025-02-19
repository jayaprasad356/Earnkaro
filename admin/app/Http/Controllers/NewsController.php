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
        ]);

        $news = News::findOrFail(1); // Editing record with ID 1
        $news->update($request->only(['telegram_link', 'customer_support_number','minimum_withdrawals','whatsapp_status_income']));

        return redirect()->route('news.edit')->with('success', 'Settings updated successfully.');
    }
}
