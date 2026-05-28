<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HmakHelpCategory extends Model
{
    protected $guarded = [];

    public function requests()
    {
        return $this->hasMany(HmakHelpUserRequest::class, 'hmak_help_category_id');
    }
}
