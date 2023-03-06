<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyCause
 * 
 * @property int $id
 * @property string $cause
 * 
 * @property Collection|CompanyRefus[] $company_refuses
 *
 * @package App\Models
 */
class CompanyCause extends Model
{
	protected $table = 'company_causes';
	public $timestamps = false;

	protected $fillable = [
		'cause'
	];

	public function company_refuses()
	{
		return $this->hasMany(CompanyRefus::class, 'company_cause_id');
	}
}
