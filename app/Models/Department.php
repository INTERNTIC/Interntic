<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property string $shortcut
 * 
 * @property Collection|DepartmentHead[] $department_heads
 * @property Collection|Level[] $levels
 *
 * @package App\Models
 */
class Department extends Model
{
	use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
	protected $table = 'departments';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'short_cut'
	];

	public function department_heads()
	{
		return $this->hasMany(DepartmentHead::class);
	}
	public function majors()
	{
		return $this->hasMany(Major::class);
	}
	public function internshipsWaiting()
	{
		return $this->hasManyDeep(InternshipRequest::class, [Major::class, LevelMajor::class,Student::class])->where('status',config('global.internship_request_status.not_seen'));
	}
	public function studentsIntershipRequestsId()
	{
		return $this->internshipsWaiting()->pluck('internship_requests.id')->toArray();
	}
	
}
