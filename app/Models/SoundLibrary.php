<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoundLibrary extends Model
{
    protected $guarded = [];

    // The underlying table might be plural: 'sound_libraries'
    protected $table = 'sound_libraries';

    public function category()
    {
        return $this->belongsTo(SoundLibraryCategory::class, 'sound_library_category_id');
    }

    public function author()
    {
        return $this->belongsTo(SoundAuthor::class, 'sound_author_id');
    }
}
