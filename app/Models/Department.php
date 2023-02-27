<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property string $shortcut
 * 
 * @property Collection|DepartmentHead[] $department_heads
 * @property Collection|Level[] $levels
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'short_cut'
	];

	public function department_heads()
	{
		return $this->hasMany(DepartmentHead::class);
	}

	public function levels()
	{
		return $this->belongsToMany(Level::class)
					->withPivot('id');
	}
}
