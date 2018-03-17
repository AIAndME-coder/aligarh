<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrivilege extends Model
{


	protected $fillable = [
		'user_id',
		'privileges'
		];

	public $timestamps = false;

	protected $casts = [
		'privileges'    =>  'object',

	];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function NavPrivileges($id, $option) {
		return isset($this->privileges->{$id}->{$option})? $this->privileges->{$id}->{$option} : 0;
	}

}
