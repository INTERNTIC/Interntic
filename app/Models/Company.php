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
 * @property Collection|InternshipResponsible[] $internship_Responsibles
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

	public function internship_Responsibles()
	{
		return $this->hasMany(InternshipResponsible::class);
	}
	public function internship_Requests()
	{
		return $this->hasMany(InternshipRequest::class);
	}
	public static function findByNameLocation($name, $location)
	{
		return self::where('name','=',$name)
        ->where('location','=',$location)->first();
	}
}
