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
		'level_major_id' => 'int'
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
	public function waitingInternshipRequests()
	{
		return $this->internship_requests->where("status",0);
	}
	public function passedInternships()
	{
		return $this->internship_requests->where("status",5);
	}
}
