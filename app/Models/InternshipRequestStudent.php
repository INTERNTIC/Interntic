<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InternshipRequestStudent
 * 
 * @property int $id
 * @property int $student_id
 * @property int $internship_request_id
 * 
 * @property InternshipRequest $internship_request
 * @property Student $student
 * @property Collection|Assessment[] $assessments
 *
 * @package App\Models
 */
class InternshipRequestStudent extends Model
{
	protected $table = 'internship_request_student';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int',
		'internship_request_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'internship_request_id'
	];

	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function assessments()
	{
		return $this->hasMany(Assessment::class);
	}
}
