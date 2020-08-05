<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $primaryKey = 'event_uid';
    protected $fillable = [
        'name', 'description', 'date', 'forum_link', 'report_link', 'charity_raised'
    ];
}
