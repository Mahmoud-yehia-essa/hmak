<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HmakHelpAttachment extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(HmakHelpUserRequest::class, 'hmak_help_user_request_id');
    }
}
