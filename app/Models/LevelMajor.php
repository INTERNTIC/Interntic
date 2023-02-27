<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LevelMajor
 * 
 * @property int $id
 * @property int $level_id
 * @property int $major_id
 * 
 * @property Level $level
 * @property Major $major
 * @property Collection|Student[] $students
 *
 * @package App\Models
 */
class LevelMajor extends Model
{
	protected $table = 'level_major';
	public $timestamps = false;

	protected $casts = [
		'level_id' => 'int',
		'major_id' => 'int'
	];

	protected $fillable = [
		'level_id',
		'major_id'
	];

	public function level()
	{
		return $this->belongsTo(Level::class);
	}

	public function major()
	{
		return $this->belongsTo(Major::class);
	}

	public function students()
	{
		return $this->hasMany(Student::class);
	}
}
