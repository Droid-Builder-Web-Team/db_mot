<?php

/**
 * Model for Achievements
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
use Dialect\Gdpr\Portable;

use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rater;
use OwenIt\Auditing\Contracts\Auditable;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;

/**
 * Achievements
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class User extends Authenticatable implements MustVerifyEmail,
                                                Rater,
                                                Auditable,
                                                ReactsInterface
{
    use Notifiable;
    use HasRoles;
    use Portable;
    use HasSettingsField;
    use CanRate;
    use Reacts;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'members';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'last_updated';

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
     * @return array of App\Droid
     */
    public function droids()
    {
        return $this->belongsToMany(Droid::class, 'droid_members');
    }

    /**
     * Get all the user's Achievements
     *
     * @return array of App\Achievement
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
     * @return array of App\Event
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
     * Events user is going to
     *
     * @return array of App\Event
     */
    public function goingTo()
    {
        return $this->belongsToMany(Event::class, 'members_events')
            ->wherePivot('status', "yes")
            ->OrderBy('date', 'desc');
    }

    /**
     * Get list of all events user has attended
     *
     * @return array of App\Event
     */
    public function attended_events()
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
     * @param App\Droid $droid Droid Model
     *
     * @return bool
     */
    public function hasDroid( Droid $droid )
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
        if (strtotime($this->pli_date) > strtotime('-1 year') ) {
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
    public function pli_expires()
    {
        $expires = Carbon::parse($this->pli_date)->addYear(1);
        return $expires;

    }

    /**
     * How many years has user been a member
     *
     * @return Carbon
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
        $url = "https://chart.googleapis.com/chart?cht=qr&chld=L|1&chs=500x500&chl="
            . urlencode($link);
        $image = imagecreatefrompng($url);
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
     * @return array of App\CourseRun
     */
    public function course_runs()
    {
        return $this->hasMany(CourseRun::class)->orderBy('final_time');
    }

    /**
     * What clubs is user a member of
     *
     * @return array of App\Clubs
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_members');
        //return false;
    }

    /**
     * Is user an admin of a club
     *
     * @param App\Club $club Club Model
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
     * @return array of App\PartsRunData
     */
    public function partsRun()
    {
        return $this->hasMany(PartsRunData::class);
    }

    /**
     * Part runs user is interested in
     *
     * @return array of App\PartsRunData
     */
    public function parts_interested()
    {
        return $this->belongsToMany(PartsRunData::class, 'members_parts')
            ->withPivot('status', 'quantity', 'shipper', 'tracking');
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
}
