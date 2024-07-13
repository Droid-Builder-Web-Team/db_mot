<?php

/**
 * Model for Clubs
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
use App\ClubOptions;
use App\Droid;

/**
 * Clubs
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Club extends Model
{
    protected $fillable = [
        'name', 'website', 'facebook', 'forum'
    ];

    /**
     * Club Options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\ClubOptions
     */
    public function options()
    {
        return $this->belongsToMany(ClubOptions::class);
    }

    /**
     * Droids belonging to club
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of App\Droid
     */
    public function droids()
    {
        return $this->hasMany(Droid::class);
    }

    /**
     * Get list of all clubs
     *
     * @return \Illuminate\Support\Collection of dict
     */
    public function listClubs()
    {
        return $this->pluck('name', 'id');
    }

    /**
     * Check if club has option set
     *
     * @param \App\ClubOptions $hasoption Option to check for
     *
     * @return bool
     */
    public function hasOption($hasoption)
    {
        $result = false;
        $options = $this->options;
        foreach ($options as $option) {
            if ($option->name == $hasoption) {
                $result = true;
            }
        }

        return $result;
    }

}
