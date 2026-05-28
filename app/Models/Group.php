<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'status',
        'invite_code',
        'admin_user_id',
    ];

    /**
     * Users who are members of this group.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')->withTimestamps();
    }

    /**
     * Subjects published in this group.
     */
    public function subjects()
    {
        return $this->hasMany(GroupSubject::class)->latest();
    }

    /**
     * The administrator (creator) of the group.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Helper to verify if a user is a member of this group.
     */
    public function isMember($userId): bool
    {
        if (!$userId) return false;
        return $this->users()->where('user_id', $userId)->exists();
    }
}
