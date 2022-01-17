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

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Achievements
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Achievement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';

    protected $guarded = [

    ];
}
