<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DepartmentRefus
 * 
 * @property int $id
 * @property int $internship_request_id
 * @property int $department_cause_id
 * 
 * @property DepartmentCause $department_cause
 * @property InternshipRequest $internship_request
 *
 * @package App\Models
 */
class DepartmentRefus extends Model
{
	protected $table = 'department_refuses';
	public $timestamps = false;

	protected $casts = [
		'internship_request_id' => 'int',
		'department_cause_id' => 'int'
	];

	protected $fillable = [
		'internship_request_id',
		'department_cause_id'
	];

	public function department_cause()
	{
		return $this->belongsTo(DepartmentCause::class);
	}

	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}
}
