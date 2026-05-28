<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoundAuthor extends Model
{
    protected $guarded = [];

    public function sounds()
    {
        return $this->hasMany(SoundLibrary::class, 'sound_author_id');
    }
}
