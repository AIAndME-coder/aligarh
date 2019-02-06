<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AcademicSession extends Model
{


	protected function getStartAttribute($start){
		return Carbon::createFromFormat('Y-m-d', $start)->format('d/m/Y');
	}

	protected function getEndAttribute($end){
		return Carbon::createFromFormat('Y-m-d', $end)->format('d/m/Y');
	}

}
