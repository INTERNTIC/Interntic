<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Offer
 * 
 * @property int $id
 * @property string $theme
 * @property string $details
 * @property string $duration
 * @property int $internship_responsible_id
 * 
 * @property InternshipResponssible $internship_responssible
 *
 * @package App\Models
 */
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

	public function internship_responssible()
	{
		return $this->belongsTo(InternshipResponssible::class, 'internship_responsible_id');
	}
}
