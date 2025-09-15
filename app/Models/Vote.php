<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ballot_id',
        'candidate_id',
        'rank'
    ];

    /**
     * Get the ballot that the vote belongs to.
     */
    public function ballot()
    {
        return $this->belongsTo(Ballot::class);
    }

    /**
     * Get the candidate that received the vote.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}