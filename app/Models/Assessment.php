<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'the_date',
		'enter_time',
		'left_time',
		'note',
		'internship_request_id'
	];

	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}
}
