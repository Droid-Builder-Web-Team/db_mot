<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueContact extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
