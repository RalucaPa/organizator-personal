<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingEventNotification extends Notification implements ShouldQueue
{
    use Queueable;

    
    protected $event;
    /**
     * Create a new notification instance.
     *
     * @param mixed $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reminder: Urmează un eveniment!')
            ->greeting('Salut, ' . $notifiable->name)
            ->line('Ai un eveniment programat în curând:')
            ->line('Titlu: ' . $this->event->title)
            ->line('Locație: ' . $this->event->location)
            ->line('Data și ora: ' . $this->event->start_time->format('d.m.Y H:i'))
            ->action('Vezi evenimentul', url('/calendar'))
            ->line('Mult succes cu organizarea!')
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
