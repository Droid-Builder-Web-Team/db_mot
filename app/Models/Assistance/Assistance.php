<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\User;

class Assistance extends Model
{
    use HasFactory;

    /**
     * Users have many Assistance Requests
     *
     * @return array of App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Type of request
     *
     * @return array of App\Assistance\Type
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Type of material
     *
     * @return array of App\Assistance\Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
