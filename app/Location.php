<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = 'location_uid';

    protected $guarded = [];
}
