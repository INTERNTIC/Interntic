<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyRefus
 * 
 * @property int $id
 * @property int $internship_request_id
 * @property int $company_causes_id
 * 
 * @property CompanyCause $company_cause
 * @property InternshipRequest $internship_request
 *
 * @package App\Models
 */
class CompanyRefus extends Model
{
	protected $table = 'company_refuses';
	public $timestamps = false;

	protected $casts = [
		'internship_request_id' => 'int',
		'company_causes_id' => 'int'
	];

	protected $fillable = [
		'internship_request_id',
		'company_causes_id'
	];

	public function company_cause()
	{
		return $this->belongsTo(CompanyCause::class, 'company_causes_id');
	}

	public function internship_request()
	{
		return $this->belongsTo(InternshipRequest::class);
	}
}
