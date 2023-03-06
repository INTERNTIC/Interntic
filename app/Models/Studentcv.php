<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class StudentCv extends Model
{
	protected $table = 'student_cvs';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int'
	];

	protected $fillable = [
		'deatails',
		'image',
		'student_id'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}
}
