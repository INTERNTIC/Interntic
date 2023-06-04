<?php

/**
 * Created by Reliese Model. 
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class StudentAccount extends Authenticatable implements JWTSubject , MustVerifyEmail
{
	use Notifiable;
	protected $table = 'student_accounts';
	public $incrementing = false;
	public $timestamps = false;


	protected $hidden = [
		'password',
		
	];

	protected $fillable = [
		'id',
		'email',
		'password',
		'token',
		'email_verified'
	];

	public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

	public function student()
	{
		return $this->belongsTo(Student::class, 'id');
	}
}
