<?php

/**
 * Model for Location
 * php version 7.4
 *
 * @category Model
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Contracts\Rateable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Location
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Location extends Model implements Rateable, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CanBeRated;

    protected $guarded = [];

    /**
     * Get list of events at venue
     *
     * @return array of Events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get venue Contact
     *
     * @return array of App\VenueContact
     */
    public function venueContact()
    {
        return $this->hasMany(VenueContact::class);
    }

    /**
     * Get comments
     *
     * @return array of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->orderBy('created_at');
    }

    /**
     * Does the location have a Rating
     *
     * @return void
     */
    public function hasRating()
    {
        //
    }

    /**
     * Get average rating
     *
     * @return int
     */
    public function gateRatingAttribute()
    {
        return $this->averageRating(User::class);
    }
}
