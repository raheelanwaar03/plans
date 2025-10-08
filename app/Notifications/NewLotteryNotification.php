<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLotteryNotification extends Notification
{
    use Queueable;
    protected $drawTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct($drawTitle)
    {
        $this->drawTitle = $drawTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Lucky Draw Available!',
            'message' => "Participate now in our new Lucky Draw: {$this->drawTitle}",
            'link' => route('User.LuckyDraw'),
            'created_at' => now()->toDateTimeString(),

        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
