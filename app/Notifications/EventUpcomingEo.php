<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Event;

class EventUpcomingEo extends Notification
{
    use Queueable;
    protected $event;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->title = "An event you created is upcoming.";
        $this->text = "One of the events you created is happening in a week. ";
        $this->text .= $event->name . ' - ('
        . $event->location->name . ' - '
        . $event->location->town . ')';
        $this->link = route('event.show', $this->event->id);
        $this->icon = "calendar";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings()->get('notifications.event') == 'on' ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Upcoming Event (Organiser)')
            ->line($this->title)
            ->action('View Event', $this->link)
            ->line($this->text);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->event->id,
            'title' => $this->title,
            'link' => $this->link,
            'text' => $this->text,
            'icon' => $this->icon
        ];
    }
}
