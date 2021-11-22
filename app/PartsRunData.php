<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Club;
use App\PartsRunImage;
use App\PartsRunAd;
use App\User;
use OwenIt\Auditing\Contracts\Auditable;

class PartsRunData extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'parts_run_data';

    protected $fillable = [
        'user_id',
        'club_id',
        'status',
        'bc_rep_id',
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

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function interested()
    {
        return $this->belongsToMany(User::class, 'members_parts')->withPivot('status', 'quantity');
    }

    public function is_interested()
    {
        return $this->belongsToMany(User::class, 'members_parts')->wherePivot('status', 'interested')->withPivot('status', 'quantity');
    }

    public function interest_quantity()
    {
        $quantity = 0;
        foreach($this->is_interested as $interest)
        {
          $quantity += $interest->pivot->quantity;
        }
        return $quantity;
    }
}
