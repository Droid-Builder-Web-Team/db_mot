<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DroidType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'droid_type';

    protected $fillable = [
        'name'
    ];

    public function partsRun()
    {
        return $this->belongsTo(PartsRunData::class);
    }

    public function partsRunAd()
    {
        return $this->belongsTo(PartsRunAd::class);
    }
}