<?php

/**
 * Model for Instructions
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
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Instructions
 *
 * @category Class
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Instructions extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'instructions';

    protected $fillable = [
        'parts_run_data_id',
        'filename',
        'filetype'
    ];

    /**
     * PartsRunData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partsRunData()
    {
        return $this->belongsTo(PartsRunData::class);
    }

    /**
     * PartsRunAd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partsRunAd()
    {
        return $this->belongsTo(PartsRunAd::class);
    }
}
