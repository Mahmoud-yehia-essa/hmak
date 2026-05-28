<?php

namespace App\Notifications;

use App\Models\NewsEye;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewsEyeStatusNotification extends Notification
{
    use Queueable;

    public $newsEye;

    /**
     * Create a new notification instance.
     */
    public function __construct(NewsEye $newsEye)
    {
        $this->newsEye = $newsEye;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = $this->newsEye->status == 'approved' 
            ? 'تم قبول خبرك: "' . $this->newsEye->title . '"'
            : 'تم رفض خبرك: "' . $this->newsEye->title . '"' . ($this->newsEye->rejection_reason ? ' بسبب: ' . $this->newsEye->rejection_reason : '');

        return [
            'cate' => 'news_eye',
            'news_eye_id' => $this->newsEye->id,
            'title' => $this->newsEye->title,
            'status' => $this->newsEye->status,
            'rejection_reason' => $this->newsEye->rejection_reason,
            'message' => $message,
            'type' => 'حالة الخبر',
        ];
    }
}
