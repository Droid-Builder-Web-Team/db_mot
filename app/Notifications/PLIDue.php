<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class PLIDue extends Notification
{
    use Queueable;
    protected $user;
    protected $title;
    protected $text;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->title = "Your PLI is due in a month";
        $this->text = "You need to pay your PLI in a month.";
        $this->link = route('user.show', $this->user->id);
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
                        ->action('View User', $this->link)
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
          'id' => $this->user->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text
        ];
    }
}
