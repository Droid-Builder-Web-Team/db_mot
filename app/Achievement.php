<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Achievement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';

    protected $guarded = [

    ];
}
