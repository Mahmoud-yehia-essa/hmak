<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSubjectReaction extends Model
{
    protected $table = 'group_subject_reactions';

    protected $fillable = [
        'group_subject_id',
        'user_id',
        'type',
    ];

    /**
     * Get the user who made the reaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject that was reacted to.
     */
    public function subject()
    {
        return $this->belongsTo(GroupSubject::class, 'group_subject_id');
    }
}
