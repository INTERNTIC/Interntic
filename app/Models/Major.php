<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Major
 * 
 * @property int $id
 * @property string $name
 * @property string $short_cut
 * 
 * @property Collection|Level[] $levels
 *
 * @package App\Models
 */
class Major extends Model
{
	protected $table = 'majors';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'short_cut'
	];

	public function levels()
	{
		return $this->belongsToMany(Level::class)
					->withPivot('id');
	}
}
