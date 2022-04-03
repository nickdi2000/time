<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Models\Course;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    //protected $appends = ['course_name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

		protected $appends = ['course_name', 'super'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

		public function course()
		{
			return $this->belongsTo(Course::class);
		}

		public function getCourseNameAttribute()
		{
			return $this->course->name;
		}

		//determine if user is super admin (dev, staff, etc)
		public function getSuperAttribute()
		{
			return $this->email == 'freddy' ? true : false;
		}
    /**
     * Generate random password
     */
    public static function generatePassword($length = 32)
    {
        return bcrypt(str_random($length));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
