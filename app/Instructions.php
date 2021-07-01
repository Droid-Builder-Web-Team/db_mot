<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'instructions';

    protected $fillable = [
        'title',
        'filepath',
        'url'
    ];

    public function partsRunAd()
    {
        return $this->belongsTo(PartsRunAd::class);
    }
}