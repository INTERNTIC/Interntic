<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SuperAdmin
 * 
 * @property int $id
 * @property string $email
 * @property string $password
 *
 * @package App\Models
 */
class SuperAdmin extends Model
{
	protected $table = 'super_admins';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'password'
	];
}
