<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Droid;
use App\User;

class CourseRun extends Model
{
    protected $guarded = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function droid()
    {
        return $this->belongsTo(Droid::class);
    }
}
