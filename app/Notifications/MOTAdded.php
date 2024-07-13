<?php

/**
 * MOT Notification
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
use App\MOT;

/**
 * MOT Added
 *
 * @category Class
 * @package  Notifications
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class MOTAdded extends Notification
{
    use Queueable;
    protected $mot;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @param \App\MOT $mot MOT Model
     *
     * @return void
     */
    public function __construct(MOT $mot)
    {
        $this->mot = $mot;
        $this->title = "An MOT has been added.";
        $this->text = "An MOT for one of your droids has been added. "
            . "If your PLI is due or about to expire, you can log into "
            . "the portal and click the Pay PLI PayPal button on your "
            . "profile page";
        $this->link = route('mot.show', $this->mot->id);
        $this->icon = "robot";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable Model to be notified
     *
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings()->get('notifications.mot')
            == 'on' ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable Model to be notified
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line($this->title)
            ->action('View MOT', $this->link)
            ->line($this->text);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable Model to be notified
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          'id' => $this->mot->id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text,
          'icon' => $this->icon
        ];
    }
}
