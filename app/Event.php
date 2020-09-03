<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{


    protected $guarded = [];


    public function members()
    {
        return $this->belongsToMany(User::class, 'members_events')->withPivot('spotter', 'date_added');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
