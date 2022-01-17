<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Event;

class EventMOT extends Notification
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
        $this->title = "An event is coming up at which you requested an MOT.";
        $this->text = "An event is coming up in a couple of days at which you've requested an MOT. ";
        $this->text .= "Please make sure that the droid(s) you wish to get an MOT for are entered on the portal ";
        $this->text .= "with all the correct details, and a front/side/rear photo is uploaded. ";
        $this->text .= "This can be done at the event, but it will help things move quicker if it is done beforehand. ";
        $this->text .= "Also, a profile picture (head and shoulders) is required for your builders pass.";
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
            ->subject($this->title)
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
