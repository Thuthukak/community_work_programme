<?php

namespace App\Notifications\CRM\Objective;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $deadIssue;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->deadIssue = $issue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'created_at' => now()->toDateTimeString(),
            'data' => [
                'message' => 'Your Action [ ' . $this->deadIssue->title . '  ] Regarding ' . $this->deadIssue->finished_at . ' Due, please confirm if extension is needed(postpone)',
                'icon' => $this->deadIssue->getAvatar(),
                'link' => route('actions.show', $this->deadIssue->id),
            ],
        ];
    }
}
