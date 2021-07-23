<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartsRunAd extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parts_run_ad';

    protected $fillable = [
        'parts_run_data_id',
        'title',
        'description',
        'history',
        'price',
        'includes',
        'image_url',
        'instructions_id',
        'location',
        'shipping_costs',
        'purchase_url',
        'contact_email'
    ];

    public function partsRun()
    {
        return $this->belongsTo(PartsRunData::class, 'parts_run_data_id');
    }

    public function instructions()
    {
        return $this->hasMany(Instructions::class);
    }
}