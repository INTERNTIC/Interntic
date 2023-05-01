<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
	protected $table = 'offers';
	public $timestamps = false;

	protected $casts = [
		'internship_responsible_id' => 'int'
	];

	protected $fillable = [
		'theme',
		'details',
		'duration',
		'internship_responsible_id'
	];

	public function internship_responsible()
	{
		return $this->belongsTo(InternshipResponsible::class, 'internship_responsible_id');
	}
}
