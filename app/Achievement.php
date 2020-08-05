<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    //
    protected $primaryKey = 'achievement_uid';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
}
