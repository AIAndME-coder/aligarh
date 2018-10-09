<?php

namespace App\Database;

class AutoloadDatabase {

	private static $databases	=	[
		'mwacademy'	=>	'muhammad_aligarh_mwacademy',
		'abcschool'	=>	'muhammad_aligarh_abcschool',
	];

	public static function loadDB(){

		$subdomain = explode('.', $_SERVER['HTTP_HOST']);

		if(strpos($subdomain[0], 'localhost') !== false) {
			return "aligarh_mwacademy";
		}
		
		return isset(self::$databases[$subdomain[0]])? self::$databases[$subdomain[0]] : '-';

	}

}