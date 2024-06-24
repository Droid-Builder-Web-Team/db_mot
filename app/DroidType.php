<?php

/**
 * Model for DroidType
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

/**
 * DroidType
 *
 * @category Class
 * @package  Models
 * @author   Rob Howdle <robhowdle94@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class DroidType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'droid_type';

    protected $fillable = [
        'name'
    ];

    /**
     * PartsRunData this type belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of App\PartsRunData
     */
    public function partsRun()
    {
        return $this->hasMany(PartsRunData::class);
    }

    /**
     * PartsRunAd this type belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo of App\PartsRunAd
     */
    public function partsRunAd()
    {
        return $this->belongsTo(PartsRunAd::class);
    }
}
