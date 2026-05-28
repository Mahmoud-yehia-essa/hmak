<?php

namespace App\Models;

use App\Models\PhotosGallery;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //
        protected $guarded = [];
         public function photos()
    {
        return $this->hasMany(PhotosGallery::class);
    }

}
