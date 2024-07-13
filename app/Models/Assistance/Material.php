<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Type;

class Material extends Model
{
    use HasFactory;

    /**
     * Get all the types this material can be used with
     *
     * @return array of App\Assistance\Type
     */
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
}
