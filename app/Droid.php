<?php

/**
 * Model for Droid
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
use App\MOT;
use App\User;
use App\Club;
use App\DroidInvite;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Droid
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Droid extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public const CREATED_AT = 'date_added';
    public const UPDATED_AT = 'last_updated';

    protected $guarded = [
    ];

    /**
     * The booted method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($droid) {
            // Delete MOTs (calling delete() on each model triggers MOT::deleting event for mot_details & comments)
            foreach ($droid->mot as $mot) {
                $mot->delete();
            }

            // Delete comments on the droid
            $droid->comments()->delete();

            // Delete pending invites
            if (method_exists($droid, 'invites')) {
                $droid->invites()->delete();
            }

            // Detach all users from pivot
            $droid->users()->detach();

            // Remove from ID badge queue if present
            if (Schema::hasTable('id_list')) {
                DB::table('id_list')->where('droid_id', $droid->id)->delete();
            }

            // Delete course runs if present
            if (Schema::hasTable('course_runs')) {
                DB::table('course_runs')->where('droid_id', $droid->id)->delete();
            }

            // Delete image directory
            Storage::deleteDirectory('droids/' . $droid->id);
        });
    }

    /**
     * List users this droid belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'droid_members');
    }

    /**
     * Pending sharing invitations for this droid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of App\DroidInvite
     */
    public function invites()
    {
        return $this->hasMany(DroidInvite::class, 'droid_id');
    }

    /**
     * What club does the droid belong to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get MOTs for droid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of App\MOT
     */
    public function mot()
    {
        return $this->hasMany(MOT::class)->orderBy('date', 'desc');
    }

    /**
     * Get date of latest MOT if available
     *
     * @return \date or 0
     */
    public function motDate()
    {
        $latest_mot = $this->mot()->latest('date')->first();
        if ($latest_mot != null) {
            return $latest_mot->date;
        }
        return 0;
    }

    /**
     * Does the droid have a valid MOT (of any kind)
     *
     * @return bool
     */
    public function hasMOT()
    {
        $valid = false;
        foreach ($this->mot as $mot) {
            if ((strtotime($mot->date) > strtotime('-1 year'))) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Has droid got a full MOT
     *
     * @return bool
     */
    public function hasFullMOT()
    {
        $valid = false;
        foreach ($this->mot as $mot) {
            if ((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "Yes")) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Has droid got an advisory MOT
     *
     * @return bool
     */
    public function hasAdvisoryMOT()
    {
        $valid = false;
        foreach ($this->mot as $mot) {
            if ((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "Advisory")) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Has droid got a WIP MOT
     *
     * @return bool
     */
    public function hasWIPMOT()
    {
        $valid = false;
        foreach ($this->mot as $mot) {
            if ((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "WIP")) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Has droid got an MOT expiring in the next month
     *
     * @return bool
     */
    public function hasExpiringMOT()
    {
        $expiring = false;
        foreach ($this->mot as $mot) {
            if ((strtotime($mot->date) < strtotime('-11 months')) && (strtotime($mot->date) > strtotime('-1 year'))) {
                $expiring = true;
            }
        }
        return $expiring;
    }

    /**
     * Display a text field with current MOT status
     *
     * @return string
     */
    public function displayMOT()
    {
        $motstatus = "No Valid MOT";
        $motstate = "alert-danger";
        if ($this->hasWIPMOT()) {
            $motstatus = "WIP " . Carbon::parse($this->motDate())
                ->isoFormat(auth()->user()->settings()->get('date_format'));
            $motstate = "alert-secondary";
        }
        if ($this->hasAdvisoryMOT()) {
            $motstatus = "Advisory " . Carbon::parse($this->motDate())
                ->isoFormat(auth()->user()->settings()->get('date_format'));
            $motstate = "alert-warning";
        }
        if ($this->hasFullMOT()) {
            $motstatus = "Valid " . Carbon::parse($this->motDate())
                ->isoFormat(auth()->user()->settings()->get('date_format'));
            $motstate = "alert-success";
        }
        if ($this->hasExpiringMOT()) {
            $motstate = "alert-primary";
        }


        $displayMOT = array("status" => $motstatus, "state" => $motstate);

        return $displayMOT;
    }

    /**
     * Get the ID of the last MOT
     *
     * @return int
     */
    public function lastMotId()
    {
        $latest_mot = $this->mot()->latest('date')->first();
        if ($latest_mot != null) {
            return $latest_mot->id;
        }
        return 0;
    }

    /**
     * Get comments for droid
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->orderBy('created_at');
    }

    /**
     * Get the secure tag URL for this droid
     *
     * @return string
     */
    public function tagUrl()
    {
        $tagSecret = env('TAG_SECRET', 'changeme');
        $baseUrl = config('app.url');
        $hash = substr(hash_hmac('sha256', $this->id, $tagSecret), 0, 8);
        return rtrim($baseUrl, '/') . "/scan/{$this->id}/{$hash}";
    }

    /**
     * Count MOTs by status
     *
     * @param string $status Result status
     *
     * @return int
     */
    public function countMOTsByStatus($status)
    {
        return $this->mot()->where('approved', $status)->count();
    }
}
