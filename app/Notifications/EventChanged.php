<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Event;

class EventChanged extends Notification
{
    use Queueable;
    protected $event;
    protected $changes;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     * @param array $changes
     * @return void
     */
    public function __construct(Event $event, array $changes = [])
    {
        $this->event = $event;
        $this->changes = $changes;
        $this->title = "Event Updated: " . $this->event->name;
        $this->text = !empty($changes)
            ? "The event \"" . $this->event->name . "\" has been updated: " . implode(', ', $changes)
            : "One of the events you are interested in has been changed.";
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
        $mail = (new MailMessage())
            ->subject('Event Updated: ' . $this->event->name)
            ->line('The event **' . $this->event->name . '** has been updated.');

        if (!empty($this->changes)) {
            $mail->line('**The following changes were made:**');
            foreach ($this->changes as $change) {
                $mail->line('• ' . $change);
            }
        } else {
            $mail->line($this->text);
        }

        return $mail->action('View Event', $this->link)
            ->line('Please review the event details and update your attendance status if needed.');
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
            'icon' => $this->icon,
            'changes' => $this->changes,
        ];
    }
}
