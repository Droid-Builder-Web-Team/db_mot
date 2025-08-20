<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;

/**
 * Nomination
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Nomination extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [
    ];

    /* Who made the nomination */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nominee()
    {
        return $this->belongsTo(User::class);
    }   

}
