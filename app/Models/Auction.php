<?php

/**
 * Model for Auction
 * php version 7.4
 *
 * @category Model
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;


/**
 * Auction
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Auction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['title', 
                            'description', 
                            'country', 
                            'currency', 
                            'type', 
                            'finish_time',
                            'timezone',
                            'user_id'
                        ];


    public function user()
    {
        return $this->hasOne(User::class);
    }   

    /**
     * List users this entering this auction
     * 
     * @return array of App\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'auction_members')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function highest()
    {
        $highest = 0;
        $winner = NULL;
        if ($this->users()->count() != 0) 
        {
            foreach ($this->users as $user) {
                if ($user != false && $user->pivot->amount > $highest) {
                    $highest = $user->pivot->amount;
                    $winner = $user;
                }
            }
        }
        return ['highest' => $highest, 'user' => $winner];
    }

    public function timeLeft() 
    {
        $end = new Carbon($this->finish_time, $this->timezone);
        return Carbon::now()->diff($end, true)->format('%d days, %h hours, %i minutes, %s seconds');
    }

    public function secondsLeft() 
    {
        $end = new Carbon($this->finish_time, $this->timezone);
        return Carbon::now()->diffInSeconds($end, false);
    }   

    /**
     * Get comments written on this auction
     *
     * @return array of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')
            ->orderBy('created_at');
    }
}
