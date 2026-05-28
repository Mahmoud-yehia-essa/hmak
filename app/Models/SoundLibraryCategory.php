<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoundLibraryCategory extends Model
{
    protected $guarded = [];

    public function sounds()
    {
        return $this->hasMany(SoundLibrary::class, 'sound_library_category_id');
    }
}
