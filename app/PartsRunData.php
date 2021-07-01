<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartsRunData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parts_run_data';

    protected $fillable = [
        'droid_type_id',
        'user_id',
        'bc_rep_id',
        'status',
        'parts_run_ad_id',
    ];

    public function partsRunAd()
    {
        return $this->hasOne(PartsRunAd::class);
    }

    public function droidType()
    {
        return $this->hasOne(DroidType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bcRep()
    {
        return $this->hasOne(BcRep::class);
    }
}