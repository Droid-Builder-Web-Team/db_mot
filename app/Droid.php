<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Droid extends Model
{
    //
    protected $primaryKey = 'droid_uid';
    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'last_updated';

    protected $fillable = [
      'name', 'style'
    ];

    public function users()
    {
      return $this->belongsToMany(User::class, 'droid_members', 'droid_uid', 'member_uid');
    }

    public function getImageAttribute()
    {
      return $this->path;
    }
}
