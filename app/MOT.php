<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Club;
use App\Droid;
use App\User;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class MOT extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    protected $table = 'mot';

    protected $guarded = [
    ];

    public function club()
    {
        return $this->droid->club();
    }

    public function droid()
    {
        return $this->belongsTo(Droid::class);
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Droid');
    }

    public function sections()
    {
        $club_id = $this->club->id;
        $sections = DB::table('mot_sections')
            ->where('club_id', $club_id)
            ->get();

        return $sections;
    }

    public static function lines($section_id)
    {
        $lines = DB::table('mot_lines')
            ->where('section_id', $section_id)
            ->get();

        return $lines;
    }

    public function detail($line)
    {

        $detail = DB::table('mot_details')
          ->where('mot_test', $line)
          ->where('mot_uid', $this->id)
          ->first();

        return $detail;
    }

    public function details()
    {

        $details = DB::table('mot_details')
          ->where('mot_uid', $this->id)
          ->get();

        return $details;
    }

    public function officer()
    {
        $officer = User::where('id', $this->user)->first();
        return $officer->forename." ".$officer->surname;
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
