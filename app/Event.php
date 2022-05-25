<?php

/**
 * Model for Event
 * php version 7.4
 *
 * @category Model
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Storage;

/**
 * Event
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Event extends Model implements \Acaronlex\LaravelCalendar\Event, Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    /**
     * Return event options
     *
     * @return null
     */
    public function getEventOptions()
    {
        return [
        ];
    }

    /**
     * Get list of users registered against an event
     *
     * @return array of App\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->withPivot('spotter', 'date_added', 'status', 'mot_required');
    }

    /**
     * Get organiser user
     */
    public function organiser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all who have said they are going
     *
     * @return array of App\User
     */
    public function going()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('status', "yes");
    }

    /**
     * Get all who have said they are no longer going
     *
     * @return array of App\User
     */
    public function notgoing()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('status', "no");
    }

    /**
     * Get all who have attended
     *
     * @return array of App\User
     */
    public function attended()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('attended', "1");
    }

    /**
     * Get all who have not attended
     *
     * @return array of App\User
     */
    public function notAttended()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('attended', "-1");
    }

    /**
     * Get location of event
     *
     * @return App\Location
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get comments written on this event
     *
     * @return array of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')
            ->orderBy('created_at');
    }

    /**
     * Get contacts for this event
     *
     * @return array of App\Contact
     */
    public function contacts()
    {
        return $this->morphToMany('App\Contact', 'contactable')
            ->orderBy('created_at');
    }

    /**
     * Is the event in the future
     *
     * @return bool
     */
    public function isFuture()
    {
        if ($this->date > now()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Required by calendar plugin isAllDay
     *
     * @return true
     */
    public function isAllDay()
    {
        return true;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->date;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->date;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->name;
    }

    /**
     * Can MOTs be done at the event
     *
     * @return bool
     */
    public function canMOT()
    {
        return $this->mot;
    }

    /**
     * Are WIP droids welcome at the event
     *
     * @return bool
     */
    public function canWIP()
    {
        return $this->wip_allowed;
    }

    /**
     * Is the event open to the public
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Check if event is Full
     *
     * @return bool
     */
    public function isFull()
    {
        if ($this->going()->count() >= $this->quantity && $this->quantity != 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Is there an image stored for this event
     *
     * @return bool
     */
    public function hasImage()
    {
        $filePath = 'events/' . $this->id . '/event_image.jpg';
        return Storage::exists($filePath);
    }

    /**
     * Notify discord an event has been created
     *
     * @param App\Event $event Event to pass
     *
     * @return null
     */
    public function createdEventNotification($event)
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook, [
                'content' =>
                    "A new event has been created in the Droid Builders Portal. "
                    . "Click below to view the event.",
                'embeds' => [
                    [
                        'title' => $event->name . ' - ' . $event->date,
                        'description' => $event->location->name . ', '
                            . $event->location->county . ', '
                            . $event->location->postcode,
                        'url' => route('event.show', $event->id),
                        'color' => '7506394',
                    ]
                ],
                 ]
            );
        }
    }

    /**
     * Notify discord an event has been updated
     *
     * @param App\Event $event Event to pass
     *
     * @return null
     */
    public function updatedEventNotification($event)
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook, [
                'content' =>
                    "An event has been updated in the Droid Builders Portal. "
                    . "Click below to view the event.",
                'embeds' => [
                    [
                        'title' => $event->name . ' - ' . $event->date,
                        'description' => $event->location->name . ', '
                            . $event->location->county . ', '
                            . $event->location->postcode,
                        'url' => route('event.show', $event->id),
                        'color' => '7506394',
                    ]
                ],
                 ]
            );
        }
    }

    /**
     * Notify discord an event has been deleted
     *
     * @param App\Event $event Event to pass
     *
     * @return null
     */
    public function deletedEventNotification($event)
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook, [
                'content' =>
                    "An event has been deleted in the Droid Builders Portal. ",
                'embeds' => [
                    [
                        'title' => $event->name . ' - ' . $event->date,
                        'description' => $event->location->name . ', '
                            . $event->location->county . ', '
                            . $event->location->postcode,
                        'color' => '7506394',
                    ]
                ],
                 ]
            );
        }
    }
}
