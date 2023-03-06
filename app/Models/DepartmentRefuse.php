<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DepartmentRefuse extends Model
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
