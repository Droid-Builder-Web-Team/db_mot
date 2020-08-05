<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $primaryKey = 'permission_uid';
    public $timestamps = false;
}
