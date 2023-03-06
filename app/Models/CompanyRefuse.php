<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CompanyRefuse extends Model
{
	protected $table = 'company_refuses';
	public $timestamps = false;

	protected $casts = [
		'internship_request_id' => 'int',
		'company_cause_id' => 'int'
	];

	protected $fillable = [
		'internship_request_id',
		'company_cause_id'
	];

	public function company_cause()
	{
		return $this->belongsTo(CompanyCause::class, 'company_cause_id');
	}

	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}
}
