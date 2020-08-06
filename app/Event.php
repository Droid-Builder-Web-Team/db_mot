<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $primaryKey = 'event_uid';

    protected $fillable = [
        'name', 'description', 'date', 'charity_raised', 'forum_link', 'report_link'
    ];

}
