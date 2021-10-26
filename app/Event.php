<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Storage;

class Event extends Model implements \Acaronlex\LaravelCalendar\Event, Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function getEventOptions()
    {
        return [
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'members_events')->withPivot('spotter', 'date_added', 'status', 'mot_required');
    }

    public function going()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('status', "yes");
    }

    public function maybe()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('status', "maybe");
    }

    public function notgoing()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('status', "no");
    }

    public function attended()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('attended', "1");
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function isFuture()
    {
        if ($this->date > now())
        {
            return true;
        } else {
            return false;
        }
    }
    public function isAllDay()
    {
        return True;
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

    public function canMOT()
    {
        return $this->mot;
    }

    public function canWIP()
    {
        return $this->wip_allowed;
    }

    public function isPublic()
    {
        return $this->public;
    }
    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId() {
		    return $this->id;
	  }

    public function hasImage() {
        $filePath = 'events/'.$this->id.'/event_image.jpg';
        return Storage::exists($filePath);
    }

    public function createdEventNotification($newevent)
     {
        $webHook = config('discord.eventhook');
        if($webHook != 'none') {
            return Http::post( $webHook, [
                'content' => "A new event has been created in the Droid Builders Portal. Click below to view the event.",
                'embeds' => [
                    [
                        'title' => $newevent->name,
                        'description' => $newevent->location->name . ', ' . $newevent->location->county . ', ' . $newevent->location->postcode,
                        'url' => route('event.show', $newevent->id),
                        'color' => '7506394',
                    ]
                ],
            ]);
        }
     }

    public function updatedEventNotification($event)
     {
        $webHook = config('discord.eventhook');
        if($webHook != 'none') {
            return Http::post( $webHook, [
                'content' => "An event has been updated in the Droid Builders Portal. Click below to view the event.",
                'embeds' => [
                    [
                        'title' => $event->name,
                        'description' => $event->location->name . ', ' . $event->location->county . ', ' . $event->location->postcode,
                        'url' => route('event.show', $event->id),
                        'color' => '7506394',
                    ]
                ],
            ]);
        }
     }

    public function deletedEventNotification($event)
     {
        $webHook = config('discord.eventhook');
        if($webHook != 'none') {
            return Http::post( $webHook, [
                'content' => "An event has been deleted in the Droid Builders Portal. ",
                'embeds' => [
                    [
                        'title' => $event->name,
                        'description' => $event->location->name . ', ' . $event->location->county . ', ' . $event->location->postcode,
                        'color' => '7506394',
                    ]
                ],
            ]);
        }
    }
}
