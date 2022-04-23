<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Material;
use Assistance;
use Offer;

class Type extends Model
{
    use HasFactory;

    /**
     * Get all the materials this type can handle
     *
     * @return array of App\Assistance\Material
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get all the materials this type can handle
     *
     * @return array of App\Assistance\Assistance
     */
    public function assistance()
    {
        return $this->belongsToMany(Assistance::class);
    }

    /**
     * Get all the materials this type can handle
     *
     * @return array of App\Assistance\Assistance
     */
    public function offer()
    {
        return $this->belongsToMany(Offer::class);
    }
}
