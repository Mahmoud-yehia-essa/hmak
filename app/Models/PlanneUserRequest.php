<?php

namespace App\Models;

use App\Models\Planne;
use Illuminate\Database\Eloquent\Model;

class PlanneUserRequest extends Model
{
                    protected $guarded = [];

       public function planne()
    {
        return $this->belongsTo(Planne::class, 'planne_id');
    }


}
