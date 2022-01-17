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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PartsRunData;
use App\PartsRunAd;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * PartsRunData
 *
 * @category Class
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class PartsRunImage extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    /**
     * Find PartRunData image is associated with
     *
     * @return App\PartsRunData
     */
    public function data()
    {
        return $this->belongsTo(PartsRunData::class);
    }

    /**
     * Find PartsRunAd image is associated with
     *
     * @return App\PartsRunAd
     */
    public function ad()
    {
        return $this->hasOneThrough(PartsRunAd::class, PartsRunData::class);
    }
}
