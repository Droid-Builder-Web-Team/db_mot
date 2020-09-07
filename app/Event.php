<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{


    protected $guarded = [];


    public function users()
    {
        return $this->belongsToMany(User::class, 'members_events')->withPivot('spotter', 'date_added', 'status');
    }

    public function going()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('status', "yes");
    }

    public function maybe()
    {
        return $this->belongsToMany(User::class, 'members_events')->wherePivot('status', "maybe");
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
