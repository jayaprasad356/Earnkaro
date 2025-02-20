<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'datetime',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

}
