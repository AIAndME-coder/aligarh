<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\HasLeave;

class Teacher extends Model
{
	use HasLeave;

	public function user()
	{
		return $this->morphOne('App\Model\User', 'userable');
	}

	public function scopeHaveCellNo($query)
	{
		return $query->where('phone', 'NOT LIKE', '21%')->whereRaw('LENGTH(phone) = 10');
	}

	public function attendances()
	{
		return $this->hasMany(TeacherAttendance::class);
	}
}
