<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class PLIExpired extends Notification
{
    use Queueable;
    protected $user;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->title = "Your PLI has Expired";
        $this->text = "You need to pay your PLI to have cover. "
            . "If you have a droid with a valid MOT you can pay your PLI "
            . "in the portal by clicking the Pay PLI button on your profile "
            . "page.";
        $this->link = route('user.show', $this->user->id);
        $this->icon = "user-circle";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings()->get('notifications.account') == 'on' ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line($this->title)
            ->action('View User', $this->link)
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
          'id' => $this->user->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text,
          'icon' => $this->icon
        ];
    }
}
