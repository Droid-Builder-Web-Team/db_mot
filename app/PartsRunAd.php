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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * PartsRunAd
 *
 * @category Class
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class PartsRunAd extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'parts_run_ad';

    protected $fillable = [
        'parts_run_data_id',
        'title',
        'description',
        'history',
        'price',
        'includes',
        'instructions_id',
        'location',
        'shipping_costs',
        'purchase_url',
        'contact_email'
    ];

    /**
     * Find associated partsRunData
     *
     * @return App\PartsRunData
     */
    public function partsRunData()
    {
        return $this->belongsTo(PartsRunData::class, 'parts_run_data_id');
    }
}
