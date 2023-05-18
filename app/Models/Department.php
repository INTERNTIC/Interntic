<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
	protected $table = 'departments';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'short_cut'
	];

	public function department_heads()
	{
		return $this->hasMany(DepartmentHead::class);
	}

	public function majors()
	{
		return $this->hasMany(Major::class);
	}

	public function internshipsWaiting()
	{
		return $this->hasManyDeep(InternshipRequest::class, [Major::class, LevelMajor::class,Student::class])->where('status',config('global.internship_request_status.not_seen'))->get();
	}
	
	public function studentsIntershipRequestsId()
	{
		return $this->internshipsWaiting()->pluck('internship_requests.id')->toArray();
	}
	
	public function internshipsAcceptedByDepartmentHead()
	{
		return $this->hasManyDeep(InternshipRequest::class, [Major::class, LevelMajor::class,Student::class])->where('status',config('global.internship_request_status.accepted_by_department_head'))->get();
	}

	public function internshipsAcceptedByDepartmentHeadId()
	{
		return $this->internshipsAcceptedByDepartmentHead()->pluck('id')->toArray();
	}
	
}
