<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentCv
 * 
 * @property int $id
 * @property string $link
 * @property int $student_id
 * 
 * @property Student $student
 *
 * @package App\Models
 */
class StudentCv extends Model
{
	protected $table = 'student_cvs';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int'
	];

	protected $fillable = [
		'link',
		'student_id'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}
}
