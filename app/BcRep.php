<?php

/**
 * Model for Builders Clubs Rep
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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * BcRep
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class BcRep extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bc_rep';

    protected $fillable = [
        'name'
    ];

    /**
     * Find user
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
