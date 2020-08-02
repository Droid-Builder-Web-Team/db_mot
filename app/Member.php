<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $primaryKey = 'member_uid';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'last_updated';
    
    protected $attributes = [
      'role' => 'user',
    ];
    
    protected $fillable = [
      'forename', 'surname'
    ];
}
