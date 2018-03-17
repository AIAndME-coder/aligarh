<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalFee extends Model
{


	public function Student(){
		return belongsTo('App\Atudent');
	}

}
