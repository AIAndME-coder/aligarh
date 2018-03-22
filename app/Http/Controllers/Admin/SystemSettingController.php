<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Larapack\ConfigWriter\Repository as ConfigWriter;

class SystemSettingController extends Controller
{

	protected $data, $Request;

	public function __Construct($Routes, Request $Request){
		$this->data['root'] = $Routes;
		$this->Request = $Request;
	}


	public function GetSetting(){
		return view('admin.system_setting', $this->data);
	}

	public function UpdateSetting(Request $request){

		$this->validate($this->Request, [
			'name'  =>  'required',
			'title'  =>  'required',
			'email'  =>  'nullable|email',
			'address'  =>  'required',
		]);

		$ConfigWriter = new ConfigWriter('systemInfo');
		$ConfigWriter->set([
				'name' => $request->input('name'),
				'title' => $request->input('title'),
				'email' => $request->input('email'),
				'address' => $request->input('address'),
				'contact_no' => $request->input('contact_no'),
			]);
		$ConfigWriter->save();

		return redirect('system-setting')->with([
			'toastrmsg' => [
				'type' => 'success', 
				'title'  =>  'System Settings',
				'msg' =>  'General Info Changed'
			]
		]);

	}

}
