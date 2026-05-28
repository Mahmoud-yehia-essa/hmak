<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsEyeRating extends Model
{
    protected $table = 'news_eye_ratings';

    protected $fillable = [
        'news_eye_id',
        'visitor_ip',
        'rating',
    ];

    public function newsEye()
    {
        return $this->belongsTo(NewsEye::class);
    }
}
