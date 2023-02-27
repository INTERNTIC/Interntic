<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class SuperAdmin
 * 
 * @property int $id
 * @property string $email
 * @property string $password
 *
 * @package App\Models
 */
class SuperAdmin extends Authenticatable implements JWTSubject 
{
	protected $table = 'super_admins';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'password'
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
}
