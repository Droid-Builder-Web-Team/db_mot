<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Event;

class EventCancelled extends Notification
{
    use Queueable;
    protected $event;
    protected $title;
    protected $text;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->title = "An event is cancelled";
        $this->text = "One of the events you are interested has been cancelled.";
        $this->link = route('event.show', $this->event->id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                      ->line($this->title)
                      ->action('View Event', $this->link)
                      ->line($this->text);
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
          'id' => $this->event->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text
        ];
    }
}
