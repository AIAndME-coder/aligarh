<?php

namespace App\Http\Controllers\Api\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Student;
use App\AcademicSession;
use App\AcademicSessionHistory;
use App\Exam;
use App\Grade;
use App\ExamRemark;

class ExamController extends Controller
{
	protected $Exams, $academic_session, $results = [];

	public function GetExams(Request $request){

		$this->academic_session		=	AcademicSessionHistory::where('student_id', $request->input('id'))
										->with(['AcademicSession' => function($qry){
											$qry->with('Exam');
										}])
										->with('classe')
										->orderBy('id', 'asc')->offset(($request->input('page') * $request->input('per_page')-1))->limit($request->input('per_page'))->first();

		if($this->academic_session){
			$this->results				=	ExamRemark::wherein('exam_id', $this->academic_session->AcademicSession->Exam->pluck('id'))
												->where('student_id', $request->input('id'))
												->with(['StudentResult'	=>	function($qry){
													$qry->with('Subject')->with('SubjectResultAttribute');
												}]
												)->get();
		}

		return response()->json([
			'ExamsData' => [
				'AcademicSession' => $this->academic_session,
				'Results' => $this->results
			],
			'ExamGrades' => Grade::all(),
		], 200, ['Content-Type' => 'application/json'], JSON_NUMERIC_CHECK);
	}

}
