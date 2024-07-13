<?php

/**
 * Model for Contacts
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
 * Contacts
 *
 * @category Class
 * @package  Models
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class Contact extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    /**
     * What model is the comment for
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function contactable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the locations that are assigned this contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function locations()
    {
        return $this->morphedByMany(Location::class, 'contactable');
    }

    /**
     * Get all of the events that are assigned this contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function events()
    {
        return $this->morphedByMany(Event::class, 'contactable');
    }
}
