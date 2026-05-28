<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsEye extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'attachment_path',
        'attachment_type',
        'location',
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(NewsEyeRating::class);
    }

    public function comments()
    {
        return $this->hasMany(NewsEyeComment::class)->where('status', 'approved')->latest();
    }

    public function allComments()
    {
        return $this->hasMany(NewsEyeComment::class)->latest();
    }

    /**
     * Get the average rating (1-5)
     */
    public function getAverageRatingAttribute(): float
    {
        $count = $this->ratings()->count();
        if ($count === 0) return 0;
        return round($this->ratings()->avg('rating'), 1);
    }

    /**
     * Get total rating count
     */
    public function getRatingCountAttribute(): int
    {
        return $this->ratings()->count();
    }
}
