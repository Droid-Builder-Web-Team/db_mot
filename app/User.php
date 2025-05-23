<?php

/**
 * Model for Users
 * php version 7.4
 *
 * @category Model
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Glorand\Model\Settings\Traits\HasSettingsField;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Droid;
use App\Event;
use App\Achievement;
use App\CourseRun;
use App\Club;
use App\PartsRunData;
use App\Models\Auction;
use App\Models\Ware;
use Dialect\Gdpr\Portable;

use OwenIt\Auditing\Contracts\Auditable;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;

/**
 * User
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class User extends Authenticatable implements
    MustVerifyEmail,
    Auditable,
    ReactsInterface
{
    use Notifiable;
    use HasRoles;
    use Portable;
    use HasSettingsField;
    use Reacts;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'members';
    public const CREATED_AT = 'created_on';
    public const UPDATED_AT = 'last_updated';

    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'usersEvents' => 'array',
    ];

    /**
     * The attributes that should be hidden for the downloadable data.
     *
     * @var array
     */
    protected $gdprHidden = ['password'];

    /**
     * The relations to include in the downloadable data.
     *
     * @var array
     */
    protected $gdprWith = ['comments', 'droids', 'mot'];

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'last_activity', 'last_updated', 'last_login', 'password', 'remember_token'
    ];

    /**
     * Get all the user's Droids
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Droid
     */
    public function droids()
    {
        return $this->belongsToMany(Droid::class, 'droid_members');
    }

    /**
     * Get all the user's Achievements
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Achievement
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'members_achievements')
            ->withPivot('notes', 'date_added');
    }

    /**
     * Has the user got an Achievement
     *
     * @param mixed $achievement Achievement to check for
     *
     * @return void
     */
    public function hasAchievement(Achievement $achievement)
    {
        return $this->achievements->contains($achievement);
    }

    /**
     * Get total of charity raised
     *
     * @return int
     */
    public function charity()
    {
        //     return $this->belongsToMany(Event::class, 'members_events')
        //     ->wherePivot('attended', "1")
        //     ->join('events', 'members_events.event_id', 'events.id')
        //     ->OrderBy('date', 'desc');

        // return $this->attended_events()->sum('charity_raised');
    }

    /**
     * Get all the user's Events
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Event
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'members_events')
            ->withPivot(
                'spotter',
                'date_added',
                'status',
                'attended',
                'mot_required'
            );
    }

    /**
     * Get all the user's Auctions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Auctions
     */
    public function auctions()
    {
        return $this->belongsToMany(Auction::class, 'auction_members')
            ->withPivot(
                'amount'
            );
    }


    /**
     * Events user is going to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Event
     */
    public function goingTo()
    {
        return $this->belongsToMany(Event::class, 'members_events')
            ->wherePivot('status', "yes")
            ->whereDate('date', '>', Carbon::now())
            ->OrderBy('date', 'desc');
    }

    /**
     * Get list of all events user has attended
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Event
     */
    public function attended_events() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->belongsToMany(Event::class, 'members_events')
            ->wherePivot('attended', "1")
            ->OrderBy('date', 'desc');
    }

    /**
     * Get status of event
     *
     * @param int $id Event ID
     *
     * @return string or null
     */
    public function event($id)
    {
        $status = $this->events->only($id)->first();
        if ($status != null) {
            return $status->pivot;
        } else {
            return null;
        }
    }

    /**
     * Does a droid belong to this user
     *
     * @param \App\Droid $droid Droid Model
     *
     * @return bool
     */
    public function hasDroid(Droid $droid)
    {
        return $this->droids->contains($droid);
    }

    /**
     * Does user have a valid PLI
     *
     * @return bool
     */
    public function validPLI()
    {
        if ((strtotime($this->pli_date) > strtotime('-1 year')) 
            && ($this->pli_type == 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Is the users PLI expiring
     *
     * @return bool
     */
    public function expiringPLI()
    {
        if ((strtotime($this->pli_date) < strtotime('-11 months'))
            && (strtotime($this->pli_date) > strtotime('-1 year'))
            && ($this->pli_type == 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * When does the PLI expire
     *
     * @return Carbon
     */
    public function pli_expires() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $expires = Carbon::parse($this->pli_date)->addYear();
        return $expires;
    }

    /**
     * How many years has user been a member
     *
     * @return int
     */
    public function yearsService()
    {
        $now = Carbon::now();
        return Carbon::parse($this->join_date)->DiffInYears($now);
    }

    /**
     * Generate a QR for user and store image
     *
     * @param int $id      ID of users badge
     * @param int $user_id id of user
     *
     * @return string
     */
    public static function generateQR($id, $user_id)
    {
        $link = url('/')."/id.php?id=".$id;
        $url = url('/chart?chl='.urlencode($link));
        //$image = imagecreatefrompng($url);
        $file = '/members/' . $user_id . '/qr_code.png';

        Storage::put($file, file_get_contents($url));

        return "Ok";
    }

    /**
     * Generate unique badge ID
     *
     * @param int $length Length of string
     *
     * @return string
     */
    public static function generateID($length)
    {
        $characters
            = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Get CourseRuns for user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of App\CourseRun
     */
    public function course_runs() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(CourseRun::class)->orderBy('final_time');
    }

    /**
     * What clubs is user a member of
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\Clubs
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_members');
        //return false;
    }

    /**
     * Is user an admin of a club
     *
     * @param \App\Club $club Club Model
     *
     * @return bool
     */
    public function isAdminOf(Club $club)
    {
        return $this->clubs->contains($club);
    }

    /**
     * Part runs user is organiser of
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany of App\PartsRunData
     */
    public function partsRun()
    {
        return $this->hasMany(PartsRunData::class);
    }

    /**
     * Marketplace Wares user is selling
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany of App\Ware
     */
    public function wares()
    {
        return $this->hasMany(Ware::class);
    }


    /**
     * Part runs user is interested in
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\PartsRunData
     */
    public function partsInterested()
    {
        return $this->belongsToMany(PartsRunData::class, 'members_parts')
            ->wherePivot('status', 'interested')
            ->withPivot('status', 'quantity', 'tracking', 'shipper')
            ->withTimestamps();
    }

    /**
     * Is the user interested in the parts run?
     *
     * @param int $partsrunid Id of the part run
     *
     * @return bool
     */
    public function isInterestedIn(int $partsrunid)
    {
        $partruns = $this->partsInterested;
        $status = false;
        foreach ($partruns as $partrun) {
            if ($partrun->id == $partsrunid) {
                return true;
            }
        }
        return false;
    }

    /**
     * Does the user have any mots
     *
     * @return bool
     */
    public function firstMot()
    {
        $count = 0;
        foreach ($this->droids as $droid) {
            $count += $droid->mot()->count();
        }
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function highestBid(Auction $auction)
    {
        $amount = 0;
        foreach ($auction->users()->where('user_id', $this->id)->get() as $user) {
            if ($amount < $user->pivot->amount) {
                $amount = $user->pivot->amount;
            }
        }
        return $amount;
    }
}
