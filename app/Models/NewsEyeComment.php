<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsEyeComment extends Model
{
    protected $table = 'news_eye_comments';

    protected $fillable = [
        'news_eye_id',
        'visitor_name',
        'visitor_ip',
        'comment',
        'status',
    ];

    public function newsEye()
    {
        return $this->belongsTo(NewsEye::class);
    }
}
