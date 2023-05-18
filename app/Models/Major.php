<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
	protected $table = 'majors';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'short_cut',
		'department_id'
	];

	public function levels()
	{
		return $this->belongsToMany(Level::class)
					->withPivot('id');
	}
	public function level_major()
	{
		return $this->hasMany(LevelMajor::class);
	}
	public function departments()
	{
		return $this->belongsTo(Department::class);
	}
	public function students()
    {
        return $this->hasManyThrough(Student::class, LevelMajor::class);
    }
}
