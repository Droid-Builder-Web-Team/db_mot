<?php

/**
 * Model for MOT
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
use App\Club;
use App\Droid;
use App\User;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * MOT
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class MOT extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    protected $table = 'mot';

    public $fillable = [
        'date',
        'location',
        'droid_id',
        'approved',
        'mot_type',
        'user',
    ];

    protected $guarded = [
    ];

    /**
     * Get club of droid associated with the MOT
     *
     * @return \App\Club
     */
    public function club()
    {
        return $this->droid->club();
    }

    /**
     * Get droid associated with MOT
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function droid()
    {
        return $this->belongsTo(Droid::class);
    }

    /**
     * Get owner of droid with this MOT
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough of App\User
     */
    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Droid');
    }

    /**
     * Get list of sections
     *
     * @return \Illuminate\Support\Collection of sections
     */
    public function sections()
    {
        $club_id = $this->club->id;
        $sections = DB::table('mot_sections')
            ->where('club_id', $club_id)
            ->get();

        return $sections;
    }

    /**
     * Get all lines for a section
     *
     * @param mixed $section_id Section to get lines for
     *
     * @return \Illuminate\Support\Collection of lines
     */
    public static function lines($section_id)
    {
        $lines = DB::table('mot_lines')
            ->where('section_id', $section_id)
            ->get();

        return $lines;
    }

    /**
     * Get detail for a line
     *
     * @param mixed $line Line number
     *
     * @return string
     */
    public function detail($line)
    {

        $detail = DB::table('mot_details')
            ->where('mot_test', $line)
            ->where('mot_uid', $this->id)
            ->first();

        return $detail;
    }

    /**
     * Get details of MOT
     *
     * @return \Illuminate\Support\Collection of details lines
     */
    public function details()
    {

        $details = DB::table('mot_details')
            ->where('mot_uid', $this->id)
            ->get();

        return $details;
    }

    /**
     * Get name of MOT officer
     *
     * @return string
     */
    public function officer()
    {
        $officer = User::where('id', $this->user)->first();
        return $officer->forename." ".$officer->surname;
    }

    /**
     * Get comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->orderBy('created_at');
    }
}
