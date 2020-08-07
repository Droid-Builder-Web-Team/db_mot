<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use App\Droid;
use App\Event;
use App\Achievement;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $table = 'members';
    protected $primaryKey = 'member_uid';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'last_updated';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all the user's Droids
     *
     * @return array of App\Droid
     */
    public function droids()
    {
        return $this->belongsToMany(Droid::class, 'droid_members', 'member_uid', 'droid_uid');
    }

    /**
     * Get all the user's Achievements
     *
     * @return array of App\Achievement
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'members_achievements', 'member_uid', 'achievement_uid')->withPivot('notes', 'date_added');
    }

    /**
     * Get all the user's Events
     *
     * @return array of App\Event
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'members_events', 'member_uid', 'event_uid')->withPivot('details', 'spotter', 'date_added');
    }


    public function hasDroid( Droid $droid )
    {
        return $this->droids->contains( $droid );
    }

public function show_my_roles()
    {

        $this->givePermissionTo('edit_achievements');
        //$roles = $this->getAllPermissions();
//dd($roles);
        return var_export($roles, true);

    }
}
