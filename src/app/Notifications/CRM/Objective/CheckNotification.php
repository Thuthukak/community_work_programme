<?php

namespace App\Notifications\CRM\Objective;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CheckNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $model;
    public $modelName;
    public $modelType;
    public $objective;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->objective = $obj;
        $this->modelType = substr($this->objective->model_type, 4);
        $this->model = $this->objective->model;
        $this->modelName = $this->model->name ?? $this->model->title;
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
                'message' => 'Your current objectives [ ' . $this->objective->title . '  ]Key results have not been updated for over seven days! Please fill in the latest achievement value and confidence index.',
                'icon' => $this->model->getAvatar(),
                'link' => $this->model->getOKrRoute(),
            ],
        ];
    }
}

