<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountRequest
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $company_name
 * @property string $company_location
 *
 * @package App\Models
 */
class AccountRequest extends Model
{
	protected $table = 'account_requests';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'phone',
		'company_name',
		'company_location'
	];
}
