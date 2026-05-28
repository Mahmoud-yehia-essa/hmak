<?php

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GroupJoinNotification extends Notification
{
    use Queueable;

    public $group;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group, User $user)
    {
        $this->group = $group;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $memberName = $this->user->fname . ' ' . $this->user->lname;
        return [
            'cate' => 'group_join',
            'group_id' => $this->group->id,
            'user_id' => $this->user->id,
            'message' => 'انضم المستخدم "' . $memberName . '" إلى مجموعتك: "' . $this->group->title . '"',
            'type' => 'انضمام عضو',
        ];
    }
}
