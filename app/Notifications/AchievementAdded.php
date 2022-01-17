<?php

/**
 * Achievement Notifications
 * php version 7.4
 *
 * @category Notification
 * @package  Notifications
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Achievement;

/**
 * Achievement Notifications
 *
 * @category Class
 * @package  Notifications
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class AchievementAdded extends Notification
{
    use Queueable;
    protected $achievement;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @param App\Achievement $achievement Achievement awarded
     *
     * @return void
     */
    public function __construct(Achievement $achievement)
    {
        $this->achievement = $achievement;
        $this->title = "An achievement has been awarded.";
        $this->text = "You have been awarded an achievement.";
        $this->link = route('achievement.show', $this->achievement->id);
        $this->icon = "trophy";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable Notifiable Object
     *
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings()
            ->get('notifications.achievement')
                == 'on' ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable Notifiable Object
     *
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
     * @param mixed $notifiable Notifiable object
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          'id' => $this->achievement->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text,
          'icon' => $this->icon
        ];
    }
}
