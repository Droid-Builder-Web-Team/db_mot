<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;
use App\Enums\AssetTypes;
use App\Enums\AssetConditions;

class Asset extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $guarded = [
    ];

    protected $casts = [
        'type' => AssetTypes::class,
        'current_state' => AssetConditions::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function current_holder()
    {
        return $this->belongsTo(User::class);
    }  

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')
            ->orderBy('created_at');
    }
}
