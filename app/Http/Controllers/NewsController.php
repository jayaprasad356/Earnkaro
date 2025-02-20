<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function invite_friends()
    {
        // Retrieve the invitation link, telegram channel, and customer support info from the database
        $news = News::findOrFail(1); // Assuming you're fetching the record with ID 1
    
        return view('invite_friends.index', [
            'invitation_link' => $news->invitation_link,
            'telegram_link' => $news->telegram_link,
            'customer_support_number' => $news->customer_support_number,
            'download_today_image' => $news->download_today_image,
        ]);
    }
    public function downloadImage($id)
{
    $news = News::find($id);

    if (!$news || !$news->download_today_image) {
        return back()->with('error', 'Image not found.');
    }

    $filePath = storage_path("admin/storage/app/public/{$news->download_today_image}");

    if (!file_exists($filePath)) {
        return back()->with('error', 'File does not exist.');
    }

    return response()->download($filePath, 'news_image_' . $news->id . '.jpg');
}

}
