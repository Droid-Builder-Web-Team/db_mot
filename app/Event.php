<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $primaryKey = 'event_uid';

    protected $guarded = [];


    public function members()
    {
        return $this->belongsToMany(User::class, 'members_events', 'event_uid', 'member_uid')->withPivot('spotter', 'date_added');
    }
}
