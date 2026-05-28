<?php

namespace App\Models;

use App\Models\userService;
use Illuminate\Database\Eloquent\Model;

class UserServicePayment extends Model
{

            protected $guarded = [];

     public function userService()
    {
        return $this->belongsTo(userService::class, 'user_service_id');
    }
}
