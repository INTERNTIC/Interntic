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
 * Class InternshipResponssible
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $company_id
 * 
 * @property Company $company
 * @property Collection|Offer[] $offers
 *
 * @package App\Models
 */
class InternshipResponssible extends Authenticatable implements JWTSubject
{
	protected $table = 'internship_responssibles';
	public $timestamps = false;

	protected $casts = [
		'company_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'phone',
		'company_id'
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

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function offers()
	{
		return $this->hasMany(Offer::class, 'internship_responsible_id');
	}
}
