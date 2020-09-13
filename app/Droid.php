<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MOT;
use App\User;
use App\Club;

class Droid extends Model
{
    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'last_updated';

    protected $guarded = [
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'droid_members');
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function mot()
    {
        return $this->hasMany(MOT::class)->orderBy('date', 'desc');
    }

    public function motDate()
    {
        $latest_mot = $this->mot()->latest('date')->first();
        if ($latest_mot != NULL)
        {
            return $latest_mot->date;
        }
        return 0;
    }

    public function hasMOT()
    {
        $valid = false;
        foreach($this->mot as $mot)
        {
            if((strtotime($mot->date) > strtotime('-1 year')))
                $valid = true;
        }
        return $valid;
    }

    public function hasFullMOT()
    {
        $valid = false;
        foreach($this->mot as $mot)
        {
            if((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "Yes"))
                $valid = true;
        }
        return $valid;
    }

    public function hasAdvisoryMOT()
    {
        $valid = false;
        foreach($this->mot as $mot)
        {
            if((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "Advisory"))
                $valid = true;
        }
        return $valid;
    }

    public function hasWIPMOT()
    {
        $valid = false;
        foreach($this->mot as $mot)
        {
            if((strtotime($mot->date) > strtotime('-1 year')) && ($mot->approved == "WIP"))
                $valid = true;
        }
        return $valid;
    }

    public function hasExpiringMOT()
    {
        $expiring = false;
        foreach($this->mot as $mot)
        {
            if((strtotime($mot->date) < strtotime('-11 months')) && (strtotime($mot->date) > strtotime('-1 year')))
                $expiring = true;
        }
        return $expiring;
    }

    public function displayMOT()
    {
        $motstatus = "No Valid MOT";
        $motstate = "alert-danger";
        if ($this->hasFullMOT()) {
            $motstatus = "Valid ".$this->motDate();
            $motstate = "alert-success";
        }
        if ($this->hasAdvisoryMOT()) {
            $motstatus = "Advisory ".$this->motDate();
            $motstate = "alert-warning";
        }
        if ($this->hasWIPMOT()) {
            $motstatus = "WIP ".$this->motDate();
            $motstate = "alert-warning";
        }
        if ($this->hasExpiringMOT()) {
            $motstate = "alert-primary";
        }

        $displayMOT = array("status" => $motstatus, "state" => $motstate);

        return $displayMOT;
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
