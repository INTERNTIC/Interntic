<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InternshipRequest
 * 
 * @property int $id
 * @property int $student_id
 * @property string $internshipResponsible_email
 * @property int $status
 * @property string $theme
 * @property Carbon $start_at
 * @property Carbon $end_at
 * 
 * @property Student $student
 * @property Collection|CompanyRefus[] $company_refuses
 * @property Collection|DepartmentRefus[] $department_refuses
 * @property Collection|Student[] $students
 *
 * @package App\Models
 */
class InternshipRequest extends Model
{
	protected $table = 'internship_requests';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'start_at',
		'end_at'
	];

	protected $fillable = [
		'student_id',
		'internshipResponsible_email',
		'status',
		'theme',
		'start_at',
		'end_at',
		'company_id',
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
	public function student()
	{
		return $this->belongsTo(Student::class);
	}
	public function marks()
	{
		return $this->hasOne(Mark::class);
	}

	public function assessments()
	{
		return $this->hasMany(Assessment::class);
	}
	public function internship_responsible()
	{
		return InternshipResponsible::where("email",$this->internshipResponsible_email)->first();
	}
		
}
