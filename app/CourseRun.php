<?php

/**
 * Model for CourseRun
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
use App\Droid;
use App\User;

/**
 * CourseRun
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class CourseRun extends Model
{
    protected $guarded = [
    ];

    /**
     * Who does this run belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * What droid did this run
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function droid()
    {
        return $this->belongsTo(Droid::class);
    }

    /**
     * Get comments written on this auction
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')
            ->orderBy('created_at');
    }
}
