<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that will be transformed to date object
     *
     * @var array
     */
    protected $dates = ['logged_in'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'email', 'first_name', 'last_name', 'password', 'image_id', 'logged_in'
    ];

    protected $casts = [
        'notifications' => 'array',
    ];

    /**
     * The functions that will be appended to attributes
     *
     * @var array
     */
    protected $appends  = ['full_name', 'online', 'logged'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function avatar()
    {
        return $this->morphOne('App\Models\Store', 'owner');
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function getOnlineAttribute()
    {
        return cache()->has('user_online_' . $this->id);
    }

    /**
     * @return bool|mixed
     */
    public function getLoggedAttribute()
    {
        return ($this->logged_in) ? $this->logged_in : false;
    }

    /**
     * @return string
     */
    public function getPictureAttribute()
    {
        if(!$this->image_id) {
            return asset(config('settings.user.default.picture'));
        }
        return ($this->avatar) ? asset('storage/' . $this->avatar->path) : asset(config('settings.user.default.picture'));
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return  $this->last_name . ' ' . $this->first_name;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        $lockoutTime      = 1;
        $maxLoginAttempts = 3;

        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );
    }
}
