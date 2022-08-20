<?php


/**
 * Comment notification
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
use App\Comment;
use App\Event;
use App\PartsRunData;

/**
 * CommentBroadcast
 *
 * @category Class
 * @package  Notifications
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class CommentBroadcast extends Notification
{
    use Queueable;
    protected $comment;
    protected $type;
    protected $title;
    protected $text;
    protected $link;
    protected $icon;

    /**
     * Create a new notification instance.
     *
     * @param $comment App\Comment Comment model
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $model = app($comment->commentable_type)::find($comment->commentable_id);
        switch ($comment->commentable_type) {
        case "App\Event":
            $type_text = "An Event";
            $model_title = $model->name;
            $this->link = route('event.show', $comment->commentable_id);
            break;
        case "App\PartsRunData":
            $type_text = "A Parts Run";
            $model_title = $model->partsRunAd->title;
            $this->link = route('parts-run.show', $comment->commentable_id);
            break;
        case "App\Models\Auction":
            $type_text = "An Auction";
            $model_title = $model->title;
            $this->link = route('auctions.show', $comment->commentable_id);
            break;
        case "App\Location":
            $type_text = "A Location";
            $model_title = $model->title;
            $this->link = route('location.show', $comment->commentable_id);
            break;
        default:
            $type_text = "An error";
            $model_title = "Null model";
            break;
        }
        $this->comment = $comment;
        $this->title = $type_text." has a broadcast";
        $this->text = "A broadcast comment has been submitted for "
            . strtolower($type_text) . " - ".$model_title;
        $this->icon = "bullhorn";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable Notifiable object
     *
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings()
            ->get('notifications.broadcast') ==
                'on' ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable Notifiable object
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Hi, " . $notifiable->forename)
            ->line($this->title)
            ->action('View on Portal', $this->link)
            ->line($this->text)
            ->line("Comment Reads:")
            ->line($this->comment->body);
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
          'id' => $this->comment->commentable_id,
          'title' => $this->title,
          'link' => $this->link,
          'text' => $this->text,
          'icon' => $this->icon
        ];
    }
}
