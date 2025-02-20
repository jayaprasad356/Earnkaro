<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'telegram_link','customer_support_number','whatsapp_status_income','minimum_withdrawals','download_today_image',
    ];
}   
