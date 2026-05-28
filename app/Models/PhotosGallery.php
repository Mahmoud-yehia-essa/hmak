<?php

namespace App\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;

class PhotosGallery extends Model
{
            protected $guarded = [];

              public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
