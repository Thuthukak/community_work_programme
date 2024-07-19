<?php

namespace App\Notifications\CRM\Objective;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $freshIssue;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->freshIssue = $issue;
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
                'message' => 'Your scheduled itinerary [ ' . $this->freshIssue->title . '  ] ' . Carbon::parse($this->freshIssue->started_at)->diffForHumans() . 'Start later, please prepare as soon as possible',
                'icon' =>  $this->freshIssue->getAvatar(),
                'link' => route('calendar.show', $this->freshIssue->id),
            ],
        ];
    }
}
