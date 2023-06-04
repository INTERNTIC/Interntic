<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
	protected $table = 'students';
	public $timestamps = false;

	protected $casts = [
		'level_major_id' => 'int',
	];

	protected $dates = [
		'birthday'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'birthday',
		'place_of_birth',
		'phone',
		'student_card',
		'social_security_num',
		'level_major_id'
	];

	public function level_major()
	{
		return $this->belongsTo(LevelMajor::class);
	}

	public function internship_requests()
	{
		return $this->hasMany(InternshipRequest::class);
	}

	public function student_account()
	{
		return $this->hasOne(StudentAccount::class, 'id');
	}

	public function student_cv_items()
	{
		return $this->hasMany(StudentCvItem::class);
	}
	public function waitingInternshipsForDepartment()
	{
		return $this->internship_requests->where("status",config("global.internship_request_status.not_seen"));
	}
	public function internshipsIAcceptedByDepartmentHead()
	{
		return $this->internship_requests->where("status",config("global.internship_request_status.accepted_by_department_head"));
	}
	public function internshipsAcceptedByInternshipResponsible()
	{
		return $this->internship_requests->where("status",config("global.internship_request_status.accepted_by_internship_responsible"));
	}
	public function internshipsAcceptedByInternshipResponsibleId()
	{
		return $this->internshipsAcceptedByInternshipResponsible()->pluck('id')->toArray();
	}
	public function passedInternships()
	{
		return $this->internship_requests->where("status",5);
	}
	public function refusedInternships()
	{
		$status=[config('global.internship_request_status.refused_by_department_head'),config('global.internship_request_status.refused_by_internship_responsible')];
		return $this->internship_requests->whereIn("status",$status);
	}
}
