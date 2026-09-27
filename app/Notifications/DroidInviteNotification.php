<?php

namespace App\Notifications;

use App\DroidInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DroidInviteNotification extends Notification
{
    use Queueable;

    public $invite;

    /**
     * Create a new notification instance.
     *
     * @param DroidInvite $invite
     */
    public function __construct(DroidInvite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable instanceof \App\User) {
            return ['mail', 'database'];
        }

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $droid = $this->invite->droid;
        $inviter = $this->invite->inviter;
        $inviterName = $inviter ? ($inviter->forename . ' ' . $inviter->surname) : 'Another builder';
        $droidName = $droid ? $droid->name : 'a droid';

        return (new MailMessage)
            ->subject('Invitation to share ownership of ' . $droidName)
            ->greeting('Hello!')
            ->line("{$inviterName} has invited you to share ownership of **{$droidName}** on the Droid Builders Portal.")
            ->line('Sharing allows you to co-manage this droid, view and update its details, and have it appear on your builder profile.')
            ->action('Accept Invitation', route('droid.invite.accept', $this->invite->token))
            ->line('This invitation link will expire in 7 days.')
            ->line('If you did not expect this invitation or do not wish to share this droid, you can safely ignore this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $droid = $this->invite->droid;
        $inviter = $this->invite->inviter;
        $inviterName = $inviter ? ($inviter->forename . ' ' . $inviter->surname) : 'Another builder';

        return [
            'id' => $droid ? $droid->id : null,
            'title' => 'Invitation to share droid ' . ($droid ? $droid->name : ''),
            'link' => route('droid.invite.accept', $this->invite->token),
            'text' => "{$inviterName} invited you to share ownership of " . ($droid ? $droid->name : 'a droid') . ".",
            'icon' => 'share-alt',
        ];
    }
}
