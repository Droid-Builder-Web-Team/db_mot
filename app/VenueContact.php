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
class VenueContact extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * Get contact's location
     *
     * @return App\Location
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
