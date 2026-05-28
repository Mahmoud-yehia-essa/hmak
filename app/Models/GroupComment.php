<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupComment extends Model
{
    protected $fillable = [
        'group_subject_id',
        'user_id',
        'content',
        'attachment_type',
        'attachment_path',
    ];

    public function subject()
    {
        return $this->belongsTo(GroupSubject::class, 'group_subject_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
