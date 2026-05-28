<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\UserServicePayment;
use Illuminate\Database\Eloquent\Model;

class userService extends Model
{

            protected $guarded = [];


             // علاقة مع المستخدم ddd
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // علاقة مع الخدمة
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // علاقة مع الدفعات
    public function payments()
    {
        return $this->hasMany(UserServicePayment::class, 'user_service_id');
    }

}
