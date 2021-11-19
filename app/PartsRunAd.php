<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class PartsRunAd extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'parts_run_ad';

    protected $fillable = [
        'parts_run_data_id',
        'title',
        'description',
        'history',
        'price',
        'includes',
        'instructions_id',
        'location',
        'shipping_costs',
        'purchase_url',
        'contact_email'
    ];

    public function partsRunData()
    {
        return $this->belongsTo(PartsRunData::class, 'parts_run_data_id');
    }
}
