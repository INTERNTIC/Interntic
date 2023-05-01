<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

	public static function findByEmail($email)
	{
		return self::where('email', '=', $email)->first();
	}

	public function internshipsWaiting()
	{
		return $this->company->internship_Requests->where('status', config('global.internship_request_status.accepted_by_department_head'))->where('internshipResponsible_email', $this->email);
	}


	public function internshipsWaitingId()
	{
		return $this->internshipsWaiting()->pluck('id')->toArray();
	}

	public function internshipsIAccepted()
	{
		return $this->company->internship_Requests->where('status', config('global.internship_request_status.accepted_by_internship_responsible'))->where('internshipResponsible_email', $this->email);
	}

	public function internshipsIAcceptedId()
	{
		return $this->internshipsIAccepted()->pluck('id')->toArray();
	}

	public function studentsMark()
	{
		return Mark::whereIn("internship_request_id", $this->internshipsIAcceptedId())->get();
	}

	public function notAssessedStudentToday()
	{
		// get all internships then remove that have assessment with currnt date
		return InternshipRequest::where('internship_requests.status', config('global.internship_request_status.accepted_by_internship_responsible'))
			->where('internship_requests.internshipResponsible_email', $this->email)
			->whereNotIn(
				'id',
				DB::table('assessments')
					->join('internship_requests', 'internship_requests.id', '=', 'assessments.internship_request_id')
					->where('assessments.the_date', "=",  date('Y-m-d'))
					->get()
					->pluck('internship_request_id')
					->toArray()
			)->get();
	}
}
