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

/**
 * Class DepartmentHead
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property int $department_id
 * 
 * @property Department $department
 *
 * @package App\Models
 */
class DepartmentHead extends Authenticatable implements JWTSubject
{
	protected $table = 'department_heads';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'department_id'
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

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}
