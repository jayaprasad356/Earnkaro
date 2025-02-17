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
            'telegram_channel' => $news->telegram_channel,
            'customer_support' => $news->customer_support,
        ]);
    }
    
}
