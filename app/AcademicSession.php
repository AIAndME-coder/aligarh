<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AcademicSession extends Model
{


	protected function getFromAttribute($from){
		return Carbon::createFromFormat('Y-m-d', $from)->format('d/m/Y');
	}

	protected function getToAttribute($to){
		return Carbon::createFromFormat('Y-m-d', $to)->format('d/m/Y');
	}

}
