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
 * @property InternshipResponsible $internship_Responsible
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

	public function internship_Responsible()
	{
		return $this->belongsTo(InternshipResponsible::class, 'internship_responsible_id');
	}
}
