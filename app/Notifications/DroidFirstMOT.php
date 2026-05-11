<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\MOT;
use App\Droid;

class DroidFirstMOT extends Notification
{
    use Queueable;
    protected $mot;
    protected $droid;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @param \App\MOT $mot MOT model
     *
     * @return void
     */
    public function __construct(MOT $mot)
    {
        $this->mot = $mot;
        $this->droid = $mot->droid;
        $owners = $this->droid->users->map(function ($user) {
            return $user->forename . " " . $user->surname;
        })->implode(', ');

        $status = $mot->approved;
        if ($status == "Yes") {
            $status = "Pass";
        }
        if ($status == "No") {
            $status = "Fail";
        }

        $this->title = "First MOT for " . $this->droid->name;
        $this->text = $this->droid->name . " (Owned by " . $owners . ") has just had its first ever MOT with status: " . $status;
        $this->link = route('droid.show', $this->droid->id);
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
        return ['database', 'mail'];
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
            ->action('View Droid', $this->link)
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
