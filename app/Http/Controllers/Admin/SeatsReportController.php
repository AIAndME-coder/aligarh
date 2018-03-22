<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classe;

class SeatsReportController extends Controller
{



	public function GetSeatsStatus(){
		$this->data['classes']	=	Classe::orderBy('numeric_name')->get();
		return view('admin.printable.seats_status_report', $this->data);
	}

}
