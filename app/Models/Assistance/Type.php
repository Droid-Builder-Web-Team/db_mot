<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Material;

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
}
