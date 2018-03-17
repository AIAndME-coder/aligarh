<?php

namespace App;

//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Student extends Model {


/*
	protected static function boot() {
		parent::boot();

		static::addGlobalScope('session_id', function (Builder $builder) {
			$builder->where('session_id', '=', Auth::user()->academic_session);
		});
	}
*/

	public function scopeCurrentSession($query){
		return $query->where('session_id', Auth::user()->academic_session);
	}

	public function scopeActive($query){
		return $query->where('active', 1);
	}

	public function Guardian() {
		return $this->belongsTo('App\Guardian');
	}

	public function Std_Class() {
		return $this->hasOne('App\Classe', 'id', 'class_id');
	}

	public function Section() {
		return $this->hasOne('App\Section', 'id', 'section_id');
	}

	public function getDateOfBirthAttribute($date){
		return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
	}

	public function getDateOfAdmissionAttribute($date){
		return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
	}

	public function AdditionalFee(){
		return $this->hasMany('App\AdditionalFee');
	}

}