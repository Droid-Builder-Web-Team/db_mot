<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Contracts\Rateable;
use OwenIt\Auditing\Contracts\Auditable;

class Location extends Model implements Rateable, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CanBeRated;

    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function venueContact()
    {
        return $this->hasMany(VenueContact::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function hasRating()
    {
        //
    }

    public function gateRatingAttribute()
    {
      return $this->averageRating(User::class);
    }
}
