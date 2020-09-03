<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Club;
use App\Droid;
use Illuminate\Support\Facades\DB;

class MOT extends Model
{
    //

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
        $club_id = $this->club->club_id;
        $sections = DB::table('mot_sections')
            ->where('club_id', $club_id)
            ->get();

        return $sections;
    }

    public function lines($section)
    {
        $club_id = $this->club->club_id;
        $lines = DB::table('mot_lines')
            ->where('club_id', $club_id)
            ->where('test_section', $section)
            ->get();

        return $lines;
    }

    public function line($line)
    {
        $detail = DB::table('mot_details')
          ->where('mot_detail_uid', $line)
          ->first();

        return $detail;
    }

    public function officer()
    {
        $name = "test";
        return $name;
    }
}
