<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

	public function scopeExaminable($query){
		$query->where('examinable', 1);
	}

}
