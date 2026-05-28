<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSubject extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'description',
        'likes',
        'dislikes',
        'attachment_type',
        'attachment_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function comments()
    {
        return $this->hasMany(GroupComment::class)->oldest();
    }

    public function reactions()
    {
        return $this->hasMany(GroupSubjectReaction::class, 'group_subject_id');
    }
}
