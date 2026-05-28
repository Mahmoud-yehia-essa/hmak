<?php

namespace App\Notifications;

use App\Models\GroupSubject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GroupNewSubjectNotification extends Notification
{
    use Queueable;

    public $subject;

    /**
     * Create a new notification instance.
     */
    public function __construct(GroupSubject $subject)
    {
        $this->subject = $subject;
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
        $authorName = $this->subject->user ? ($this->subject->user->fname . ' ' . $this->subject->user->lname) : 'مراسل';
        $groupTitle = $this->subject->group ? $this->subject->group->title : 'المجموعة';
        
        return [
            'cate' => 'group_subject',
            'group_id' => $this->subject->group_id,
            'subject_id' => $this->subject->id,
            'message' => 'قام "' . $authorName . '" بنشر موضوع جديد: "' . $this->subject->title . '" في مجموعتك: "' . $groupTitle . '"',
            'type' => 'موضوع جديد',
        ];
    }
}
