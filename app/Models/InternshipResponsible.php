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
 * Class InternshipResponsible
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
class InternshipResponsible extends Authenticatable implements JWTSubject
{
	protected $table = 'internship_responsibles';
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
	public function studentsIntershipRequests()
    {
        return $this->company->internship_Requests->where('status',config('global.internship_request_status.accepted_by_department_head'))->where('internshipResponsible_email',$this->email);
    }
	public function studentsIntershipRequestsId()
    {
		return $this->studentsIntershipRequests()->pluck('id')->toArray();
    }
	public function studentsInterships()
    {
        return $this->company->internship_Requests->where('status',config('global.internship_request_status.accepted_by_internship_responsible'))->where('internshipResponsible_email',$this->email);
    }
	public function studentsIntershipIds()
    {
		return $this->studentsInterships()->pluck('id')->toArray();
    }
}
