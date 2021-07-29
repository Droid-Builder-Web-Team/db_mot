<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Club;
use App\PartsRunImage;
use App\PartsRunAd;
use App\User;

class PartsRunData extends Model
{
    use HasFactory;

    protected $table = 'parts_run_data';

    protected $fillable = [
        'club_id',
        'user_id',
        'bc_rep_id',
        'status',
    ];

    public function partsRunAd()
    {
        return $this->hasOne(PartsRunAd::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bcRep()
    {
        return $this->hasOne(User::class, 'id', 'bc_rep_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function images()
    {
        return $this->hasMany(PartsRunImage::class);
    }
}
