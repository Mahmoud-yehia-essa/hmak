<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HmakHelpUserRequest extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(HmakHelpCategory::class, 'hmak_help_category_id');
    }

    public function attachments()
    {
        return $this->hasMany(HmakHelpAttachment::class, 'hmak_help_user_request_id');
    }
}
