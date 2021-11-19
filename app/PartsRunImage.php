<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PartsRunData;
use App\PartsRunAd;
use OwenIt\Auditing\Contracts\Auditable;

class PartsRunImage extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
