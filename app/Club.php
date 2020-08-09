<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ClubOptions;

class Club extends Model
{
    protected $primaryKey = 'club_uid';
    protected $fillable = [
        'name', 'website', 'facebook', 'forum'
    ];
    public function options()
    {
        $collection = $this->hasMany(ClubOptions::class, 'club_uid');
        return $collection;
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
