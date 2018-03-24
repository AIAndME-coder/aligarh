<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;
use App\InvoiceMaster;
use App\InvoiceDetail;
use Auth;
use Carbon\Carbon;
use Request;
use App\Student;
use App\AdditionalFee;
use DB;
use PDF;
use App\Http\Controllers\Controller;

class FeesController extends Controller
{

	//  protected $Routes;
	protected $data, $InvoiceMaster, $Request, $Input, $AuthUser, $Student, $AdditionalFee;

	protected $mons = [
			1 => "Jan", 2 => "Feb",
			3 => "Mar", 4 => "Apr",
			5 => "May", 6 => "Jun",
			7 => "Jul", 8 => "Aug",
			9 => "Sep", 10 => "Oct",
			11 => "Nov", 12 => "Dec"
			];

	public function __Construct($Routes, $Request){
		$this->data['root'] = $Routes;
		// Illuminate\hTTP\Request;
		$this->Request = $Request;
		$this->Input = $Request->input();
	}

	public function Index(){
/*		echo "<pre>";
		print_r($this->Input);
		echo "</pre>";*/

		if (Request::ajax()) {
			return Datatables::eloquent(InvoiceMaster::query())->make(true);
/*			return Datatables::eloquent(InvoiceMaster::select(['invoice_master.*', 'students.name'])
				->join('students', 'invoice_master.student_id', '=', 'students.id'))
				->make(true);
*/
/*			return Datatables::queryBuilder(DB::table('invoice_master')
				->select(['invoice_master.*', 'invoice_master.id AS invoice_id', 'students.name'])
				->leftjoin('students', 'invoice_master.student_id', '=', 'students.id'))
				->make(true);*/
		}
		$this->data['months'] = $this->mons;
		$this->data['year'] = Carbon::now()->year;
	    return view('admin.fee', $this->data);
	}

	public function FindStudent(){
		if (Request::ajax()) {
			$students = Student::where('gr_no', 'LIKE', '%'.$this->Input['q'].'%')
								->orwhere('name', 'LIKE', '%'.$this->Input['q'].'%')
									->get();
			foreach ($students as $k=>$student) {
				$data[$k]['id'] = $student->id;
				$data[$k]['text'] = $student->gr_no.' | '.$student->name;
/*				$data[$k]['htm1'] = '<span class="text-danger">';
				$data[$k]['htm2'] = '</span>';*/
			}
			return response(isset($data)? $data : [0 => ['text' => 'No Data Available']]);
		}
		return abort(404);
	}

	public function CreateInvoice(){
		$this->validate($this->Request, [
			'gr_no'  	=>  'required',
			'month'  	=>  'required',
    	]);

		$this->data['student'] = Student::find($this->Request->input('gr_no'));

		if (empty($this->data['student'])) {
			return redirect()->back()->withInput()->withErrors(['gr_no' => 'GR No Not Found !']);
		}

		$this->data['invoice'] = InvoiceMaster::where([
											'payment_month' => $this->Request->input('month'),
											'gr_no' => $this->data['student']->gr_no,
											])->first();

		$this->data['Input'] = $this->Request->input();
		return $this->Index();
	}

	public function UpdateInvoice(){

		$this->validate($this->Request, [
			'payment_type'  	=>  'required',
			'chalan_no'		=>	'required_if:payment_type,Chalan'
		]);

		$this->Student = Student::findOrfail($this->data['root']['option']);
		$this->AdditionalFee = $this->Student->AdditionalFee;

		$this->SaveInvoice();
		$this->SaveDetails();

		return redirect('fee')->with([
			'toastrmsg' => [
				'type' => 'success', 
				'title'  =>  'Fee Collected',
				'msg' =>  'Save Changes Successfull'
			],
			'invoice_created' => $this->InvoiceMaster->id,
		]);
	}

	public function PrintInvoice(){
		$this->data['invoice'] = InvoiceMaster::findOrfail($this->data['root']['option']);
//		return PDF::loadView('admin.printable.view_invoice', $this->data)->stream();
		return view('admin.printable.view_invoice', $this->data);
	}

	protected function SaveInvoice(){
		$this->InvoiceMaster	=	InvoiceMaster::updateOrCreate(
					[
						'student_id' => $this->Student->id,
						'payment_month' => $this->Input['date'],
					],
					[
						'user_id' => Auth::user()->id,
						'gr_no' => $this->Student->gr_no,
						'total_amount' => $this->Student->total_amount,
						'discount' => $this->Student->discount,
						'paid_amount' => $this->Student->net_amount,
						'payment_type' => $this->Request->input('payment_type'),
						'chalan_no' => ($this->Request->input('payment_type') == 'Chalan')? $this->Request->input('chalan_no') : null,
						'date' => Carbon::now()->toDateString(),
					]
				);
	}

	protected function SaveDetails(){
		InvoiceDetail::updateOrCreate(
			[
				'invoice_id'	=>	$this->InvoiceMaster->id,
				'fee_name'		=>	'Tuition Fee'
			],
			[
				'amount'	=>	$this->Student->tuition_fee
			]
		);

		foreach ($this->AdditionalFee as $row) {
			InvoiceDetail::updateOrCreate(
				[
					'invoice_id'	=>	$this->InvoiceMaster->id,
					'fee_name'		=>	$row->fee_name
				],
				[
					'amount'	=>	$row->amount
				]
			);
		}
	}

}
