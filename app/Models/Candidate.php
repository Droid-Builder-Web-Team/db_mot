<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ballot_id',
        'name',
        'description',
    ];

    /**
     * Get the ballot that the candidate belongs to.
     */
    public function ballot()
    {
        return $this->belongsTo(Ballot::class);
    }
}

