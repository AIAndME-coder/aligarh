<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Section extends Model
{

	public function Classe() {
		return $this->belongsTo('App\Classe', 'class_id');
	}

	public function Teacher() {
		return $this->belongsTo('App\Teacher');
	}

	public function Students(){
		return $this->hasMany('App\Student');
	}

	public function AddDefaultSection($classid, $teacherid){
		$this->name = 'Section A';
		$this->nick_name = 'A';
		$this->class_id = $classid;
		$this->teacher_id = $teacherid;
		$this->created_by	=	Auth::user()->id;
		$this->save();
	}
}
