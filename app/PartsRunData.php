<?php

/**
 * Model for PartsRunAd
 * php version 7.4
 *
 * @category Model
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Club;
use App\PartsRunImage;
use App\PartsRunAd;
use App\User;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Tags\HasTags;

/**
 * PartsRunData
 *
 * @category Class
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class PartsRunData extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasTags;

    protected $table = 'parts_run_data';

    protected $fillable = [
        'user_id',
        'club_id',
        'status',
        'bc_rep_id',
        'open'
    ];

    /**
     * Get associated partsRunAd
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partsRunAd()
    {
        return $this->hasOne(PartsRunAd::class);
    }

    /**
     * Get person organising part run
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get bc Rep for run
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bcRep()
    {
        return $this->hasOne(User::class, 'id', 'bc_rep_id');
    }

    /**
     * Get club for run
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get list of images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of PartsRunImage
     */
    public function images()
    {
        return $this->hasMany(PartsRunImage::class);
    }

    /**
     * Get comments for run
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany of App\Comment
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->orderBy('created_at');
    }

    /**
     * Get list of members who have registered interest at any point with pivot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function interested()
    {
        return $this->belongsToMany(User::class, 'members_parts')
            ->withPivot('status', 'quantity', 'tracking', 'shipper', 'timestamp', 'updated_at')
            ->orderBy('timestamp')->withTimestamps();
    }


    /**
     * Get list of users currently interested
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function isInterested()
    {
        return $this->belongsToMany(User::class, 'members_parts')
            ->wherePivotIn('status', ['interested'])
            ->withPivot('status', 'quantity', 'tracking', 'shipper', 'timestamp');
    }

    /**
     * Check if a user can buy this part, or if they are on the reserve list
     *
     * @param User $user User object to check
     *
     * @return boolean
     */
    public function canBuy(User $user)
    {
        $interested = $this->isInterested()->orderBy('timestamp', 'asc')->get();
        $interested = $interested->take($this->partsRunAd->quantity);
        if ($interested->contains('id', $user->id)) {
            return true;
        }
        return false;
    }

    /**
     * Get list of members who have registered interest at any point
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany of App\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'members_parts')
            ->withPivot('status');
    }

    /**
     * Get interest quantity
     *
     * @return int
     */
    public function interestQuantity()
    {
        $quantity = 0;
        foreach ($this->isInterested as $interest) {
            $quantity += $interest->pivot->quantity;
        }
        return $quantity;
    }

    /**
     * Produce a tracking  URL (or just a string)
     *
     * @param int    $id      Tracking ID
     * @param string $shipper Shipment company
     *
     * @return string
     */
    public function trackingUrl($id, $shipper)
    {
        switch ($shipper) {
            case "Royal Mail":
                $url = "http://www.royalmail.com/portal/rm/track?trackNumber="
                . $id;
                $display = "<a target=\"_default\" href=\"" . $url
                . "\">" . $id . "</a>";
                break;
            case "Parcel Force":
                $url = "http://www.parcelforce.com/portal/pw/track?trackNumber="
                . $id;
                $display = "<a target=\"_default\" href=\"" . $url
                . "\">" . $id . "</a>";
                break;
            case "Hermes":
                $url = "https://new.myhermes.co.uk/track.html#/parcel/" . $id;
                $display = "<a target=\"_default\" href=\"" . $url
                . "\">" . $id . "</a>";
                break;
            case "DPD":
                $url = "http://www.dpd.co.uk/tracking/quicktrack.do?"
                . "search.consignmentNumber="
                . $id
                . "&search.searchType=16&search.javascriptValidated=0&appmode=guest";
                $display = "<a target=\"_default\" href=\"" . $url
                    . "\">" . $id . "</a>";
                break;
            case "Yodel":
                $display = $id;
                break;
            case "UPS":
                $url = "https://wwwapps.ups.com/tracking/tracking.cgi?"
                . "tracknum="
                . $id;
                $display = "<a target=\"_default\" href=\"" . $url
                    . "\">" . $id . "</a>";
                break;
            case "Other":
                $display = $id;
                break;
            case "None":
                $display = "No Tracking";
                break;
            default:
                $url = "";
                $display = $id;
        }

        return $display;
    }
}
