<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Assessment
 * 
 * @property int $id
 * @property Carbon $the_date
 * @property Carbon $enter_time
 * @property Carbon $left_time
 * @property string $note
 * @property int $internship_request_student_id
 * 
 * @property InternshipRequestStudent $internship_request_student
 *
 * @package App\Models
 */
class Assessment extends Model
{
	protected $table = 'assessments';
	public $timestamps = false;

	protected $casts = [
		'internship_request_student_id' => 'int'
	];

	protected $dates = [
		'the_date',
		'enter_time',
		'left_time'
	];

	protected $fillable = [
		'the_date',
		'enter_time',
		'left_time',
		'note',
		'internship_request_student_id'
	];

	public function internship_request_student()
	{
		return $this->belongsTo(InternshipRequestStudent::class);
	}
}
