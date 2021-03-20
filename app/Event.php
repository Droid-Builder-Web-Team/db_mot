<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model implements \Acaronlex\LaravelCalendar\Event
{


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
}
