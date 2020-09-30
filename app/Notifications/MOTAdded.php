<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\MOT;

class MOTAdded extends Notification
{
    use Queueable;
    protected $mot;
    protected $title;
    protected $text;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MOT $mot)
    {
        $this->mot = $mot;
        $this->title = "An MOT has been added.";
        $this->text = "An MOT for one of your droids has been added.";
        $this->link = route('mot.show', $this->mot->id);
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
                      ->action('View MOT', $this->link)
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
          'id' => $this->mot->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text
        ];
    }
}
