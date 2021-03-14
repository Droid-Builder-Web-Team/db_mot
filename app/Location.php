<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Contracts\Rateable;

class Location extends Model implements Rateable
{

    use CanBeRated;

    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class);
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
