<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;


class Instructions extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'instructions';

    protected $fillable = [
        'parts_run_data_id',
        'filename',
        'filetype'
    ];

    public function partsRunData()
    {
        return $this->belongsTo(PartsRunData::class);
    }

    public function partsRunAd()
    {
        return $this->belongsTo(PartsRunAd::class);
    }
}
