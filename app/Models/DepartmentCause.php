<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DepartmentCause
 * 
 * @property int $id
 * @property string $cause
 * 
 * @property Collection|DepartmentRefus[] $department_refuses
 *
 * @package App\Models
 */
class DepartmentCause extends Model
{
	protected $table = 'department_causes';
	public $timestamps = false;

	protected $fillable = [
		'cause'
	];

	public function department_refuses()
	{
		return $this->hasMany(DepartmentRefus::class);
	}
}
