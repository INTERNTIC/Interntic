<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * 
 * @property int $id
 * @property string $name
 * @property string $location
 * 
 * @property Collection|InternshipResponssible[] $internship_responssibles
 *
 * @package App\Models
 */
class Company extends Model
{
	protected $table = 'companies';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'location'
	];

	public function internship_responssibles()
	{
		return $this->hasMany(InternshipResponssible::class);
	}
}
