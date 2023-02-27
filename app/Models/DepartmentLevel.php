<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DepartmentLevel
 * 
 * @property int $id
 * @property int $department_id
 * @property int $level_id
 * 
 * @property Department $department
 * @property Level $level
 *
 * @package App\Models
 */
class DepartmentLevel extends Model
{
	protected $table = 'department_level';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int',
		'level_id' => 'int'
	];

	protected $fillable = [
		'department_id',
		'level_id'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function level()
	{
		return $this->belongsTo(Level::class);
	}
}
