<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PartsRunData;
use App\PartsRunAd;

class PartsRunImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function data()
    {
        return $this->belongsTo(PartsRunData::class);
    }

    public function ad()
    {
        return $this->hasOneThrough(PartsRunAd::class, PartsRunData::class);
    }
}
