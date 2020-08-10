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


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    protected $table = 'members';
    protected $primaryKey = 'member_uid';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'last_updated';

    protected $fillable = [
        'last_login',
        'last_login_from',
        'email',
        'forename',
        'surname',
        'password',
        'county',
        'postcode',
        'username',
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

    public function droidsCount()
    {
        $count = $this->droids()->count();
        return $count;
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
        return $this->belongsToMany(Event::class, 'members_events', 'member_uid', 'event_uid')->withPivot('spotter', 'date_added');
    }


    public function hasDroid( Droid $droid )
    {
        return $this->droids->contains( $droid );
    }

    public function validPLI()
    {
        if ( strtotime($this->pli_date) > strtotime('-1 year') ) {
            return true;
        } else {
            return false;
        }
    }

    public function expiringPLI()
    {
        if ((strtotime($this->pli_date) < strtotime('-11 months')) && (strtotime($this->pli_date) > strtotime('-1 year'))) {
            return true;
        } else {
            return false;
        }
    }

    public function generateQR($id) {
        $link = url('/')."/id.php?id=".$id;
        $url = "https://chart.googleapis.com/chart?cht=qr&chld=L|1&chs=100x100&chl=".urlencode($link);
        $image = imagecreatefrompng($url);
        imagejpeg($image, $path, 75);
        return "Ok";
    }

    public function generateID($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
