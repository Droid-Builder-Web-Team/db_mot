<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ClubOptions;
use App\Droid;

class Club extends Model
{


    protected $fillable = [
        'name', 'website', 'facebook', 'forum'
    ];

    public function options()
    {
        return $this->hasMany(ClubOptions::class, 'club_id');
    }

    public function droids()
    {
        return $this->hasMany(Droid::class);
    }

    public function listClubs()
    {
        return $this->pluck('name', 'id');
    }

    public function hasOption($hasoption)
    {
        $result = false;
        $options = $this->options;
        foreach ($options as $option) {
          if ($option->name == $hasoption)
            $result = true;
        }

        return $result;
    }

}
