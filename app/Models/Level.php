<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Level
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Department[] $departments
 * @property Collection|Major[] $majors
 *
 * @package App\Models
 */
class Level extends Model
{
	protected $table = 'levels';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
	public function majors()
	{
		return $this->belongsToMany(Major::class)
					->withPivot('id');
	}
}
