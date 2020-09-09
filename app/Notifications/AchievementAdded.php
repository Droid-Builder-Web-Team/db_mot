<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Achievement;

class AchievementAdded extends Notification
{
    use Queueable;
    protected $achievement;
    protected $title;
    protected $text;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Achievement $achievement)
    {
        $this->achievement = $achievement;
        $this->title = "An achievement has been awarded.";
        $this->text = "You have been awarded an achievement.";
        $this->link = route('achievement.show', $this->achievement->id);
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
                    ->action('View Achievement', $this->link)
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
          'id' => $this->achievement->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text
        ];
    }
}
