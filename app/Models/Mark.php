<?php
namespace App\Models;

use App\Models\InternshipRequest;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
	public $timestamps = false;

	protected $fillable = [
		"discipline",
		"skills",
		"initiative",
		"creativity",
		"knowledge",
		"internship_request_id",
	];
	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}
}
