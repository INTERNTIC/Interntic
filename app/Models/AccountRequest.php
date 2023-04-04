<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


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
		'company_id',
	];
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
