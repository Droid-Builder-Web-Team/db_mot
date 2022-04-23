<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * Users have many Assistance Offers
     *
     * @return array of App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get type
     *
     * @return array of App\Assistance\Type
     */
    public function type()
    {
        return $this->hasOne(Type::class);
    }

    /**
     * Get type
     *
     * @return array of App\Assistance\Type
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
