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
use Illuminate\Support\Carbon;
use App\Location;

/**
 * Event
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Event extends Model implements \DPoulson\LaravelCalendar\Event, Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'is_stem' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($event) {
            \Illuminate\Support\Facades\DB::table('event_views')->where('event_id', $event->id)->delete();
        });
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->withPivot('spotter', 'date_added', 'status', 'mot_required', 'attended');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function going()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('status', "yes");
    }

    /**
     * Get all who are on the waiting list
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function reserve()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('status', "reserve")
            ->orderBy('members_events.date_added', 'asc');
    }

    /**
     * Get all who have said they are no longer going
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function notgoing()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('status', "no");
    }

    /**
     * Get all who have attended
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function attended()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('attended', "1");
    }

    /**
     * Get all who have not attended
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function notAttended()
    {
        return $this->belongsToMany(User::class, 'members_events')
            ->wherePivot('attended', "-1");
    }

    /**
     * Get location of event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get comments written on this event
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')
            ->orderBy('created_at');
    }

    /**
     * Get contacts for this event
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany of App\Contact
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
        return $this->date >= now()->toDateString();
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
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->date;
    }

    /**
     * Get the end time
     *
     * @return \DateTime
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
     * @param \App\Event $event Event to pass
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function createdEventNotification($event)
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook,
                [
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
     * @param \App\Event $event Event to pass
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function updatedEventNotification($event, array $changes = [])
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            $description = $event->location->name . ', '
                . $event->location->county . ', '
                . $event->location->postcode;

            if (!empty($changes)) {
                $description .= "\n\n**Changes:**\n• " . implode("\n• ", $changes);
            }

            return Http::post(
                $webHook,
                [
                    'content' =>
                        "An event has been updated in the Droid Builders Portal. "
                        . "Click below to view the event.",
                    'embeds' => [
                        [
                            'title' => $event->name . ' - ' . $event->date,
                            'description' => $description,
                            'url' => route('event.show', $event->id),
                            'color' => '7506394',
                        ]
                    ],
                ]
            );
        }
    }

    /**
     * Build human-readable descriptions of changes made to the event
     *
     * @param array $dirty
     * @return array
     */
    public function getReadableChanges(array $dirty): array
    {
        $changes = [];
        $ignored = ['id', 'created_at', 'updated_at', 'created_by', 'approved', '_token', '_method'];

        foreach ($dirty as $key => $newValue) {
            if (in_array($key, $ignored, true)) {
                continue;
            }

            $oldValue = $this->getOriginal($key);

            if ($oldValue === $newValue || (is_numeric($oldValue) && is_numeric($newValue) && (string) $oldValue === (string) $newValue)) {
                continue;
            }

            switch ($key) {
                case 'name':
                    $changes[] = "Name changed from '{$oldValue}' to '{$newValue}'";
                    break;
                case 'date':
                    try {
                        $oldFormatted = Carbon::parse($oldValue)->isoFormat('dddd Do MMMM YYYY');
                        $newFormatted = Carbon::parse($newValue)->isoFormat('dddd Do MMMM YYYY');
                        $changes[] = "Date changed from {$oldFormatted} to {$newFormatted}";
                    } catch (\Exception $e) {
                        $changes[] = "Date changed from '{$oldValue}' to '{$newValue}'";
                    }
                    break;
                case 'location_id':
                    $oldLoc = Location::find($oldValue);
                    $newLoc = Location::find($newValue);
                    $oldName = $oldLoc ? $oldLoc->name : ($oldValue ? "Location #{$oldValue}" : 'None');
                    $newName = $newLoc ? $newLoc->name : ($newValue ? "Location #{$newValue}" : 'None');
                    $changes[] = "Location changed from '{$oldName}' to '{$newName}'";
                    break;
                case 'description':
                    if (trim(strip_tags((string) $oldValue)) !== trim(strip_tags((string) $newValue))) {
                        $changes[] = "Event description was updated";
                    }
                    break;
                case 'parking_details':
                    $changes[] = "Parking details were updated";
                    break;
                case 'quantity':
                    $changes[] = "Droid limit changed from {$oldValue} to {$newValue}";
                    break;
                case 'mot':
                    if ((bool) $oldValue !== (bool) $newValue) {
                        $changes[] = (bool) $newValue ? 'MOTs are now allowed at this event' : 'MOTs are no longer allowed at this event';
                    }
                    break;
                case 'public':
                    if ((bool) $oldValue !== (bool) $newValue) {
                        $changes[] = (bool) $newValue ? 'Event is now public' : 'Event is now private';
                    }
                    break;
                case 'wip_allowed':
                    if ((bool) $oldValue !== (bool) $newValue) {
                        $changes[] = (bool) $newValue ? 'WIP droids are now allowed' : 'WIP droids are no longer allowed';
                    }
                    break;
                case 'sw_only':
                    if ((bool) $oldValue !== (bool) $newValue) {
                        $changes[] = (bool) $newValue ? 'Event is now Star Wars Only' : 'Event is no longer Star Wars Only';
                    }
                    break;
                case 'is_stem':
                    if ((bool) $oldValue !== (bool) $newValue) {
                        $changes[] = (bool) $newValue ? 'Event is now designated as STEM/STEAM' : 'Event is no longer designated as STEM/STEAM';
                    }
                    break;
                case 'url':
                    $changes[] = "Event URL was updated";
                    break;
                case 'forum_link':
                    $changes[] = "Forum link was updated";
                    break;
                case 'report_link':
                    $changes[] = "Event report link was updated";
                    break;
                case 'charity_raised':
                    if ((float) $oldValue !== (float) $newValue) {
                        $changes[] = "Charity raised amount was updated to £{$newValue}";
                    }
                    break;
                default:
                    $field = ucwords(str_replace('_', ' ', $key));
                    $changes[] = "{$field} was updated";
                    break;
            }
        }

        return $changes;
    }

    /**
     * Notify discord an event has been deleted
     *
     * @param \App\Event $event Event to pass
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function deletedEventNotification($event)
    {
        $webHook = config('discord.eventhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook,
                [
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

    /**
     * Notify committee discord an event has been created
     *
     * @param \App\Event $event Event to pass
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function createdEventNotificationCommittee($event)
    {

        if ($event->approved == 1) {
            $content = "An event has been created in the Portal. ";
        } else {
            $content = "A user (" . $event->organiser->forename . " " . $event->organiser->surname . ") has submitted an event in the portal, please check and approve it.";
        }
        $webHook = config('discord.managementhook');
        if ($webHook != 'none') {
            return Http::post(
                $webHook,
                [
                    'content' => $content,
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
