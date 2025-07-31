<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Section;
use App\Student;
use App\Teacher;
use App\Employee;
use Carbon\Carbon;
use App\AttendanceLeave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;



class AttendanceLeaveController extends Controller
{
	public function Index(Request $request)
	{
		if ($request->ajax()) {
			return DataTables::eloquent(
				AttendanceLeave::select('person_type', 'from_date', 'to_date', 'remarks')
			)
			->editColumn('person_type', function ($row) {
				return class_basename($row->person_type);
			})
			->make(true);
		}

		$data['classes'] = Classe::select('id', 'name')->get();
		$data['teachers'] = Teacher::select('id', 'name')->get();
		$data['employees'] = Employee::NotDeveloper()->select('id', 'name')->get();
		$data['students'] = Student::select('id', 'name', 'class_id', 'session_id')->get();
		foreach ($data['classes'] as $key => $class) {
			$data['sections']['class_' . $class->id] = Section::select('name', 'id')->where(['class_id' => $class->id])->get();
		}

		return view('admin.attendance_leave', $data);
	}


	public function MakeLeave(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'type' => 'required|in:student,teacher,employee',
				'from_date' => 'required',
				'to_date' => 'required|after_or_equal:from_date',
				'person_id' => 'required',
				'remarks' => 'required',
			]
		);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput()
				->with([
					'toastrmsg' => [
						'type' => 'Attendance Leave',
						'title' => 'Leave',
						'msg' => 'There was an issue while Creating Leave',
					],
				]);
		}

		$modelMap = [
			'student' => Student::class,
			'teacher' => Teacher::class,
			'employee' => Employee::class,
		];

		$modelClass = $modelMap[$request->type] ?? null;
		if (!$modelClass) {
			return redirect()->back()->withErrors(['type' => 'Invalid type']);
		}

		$modelInstance = $modelClass::findOrFail($request->person_id);

		$leave = new AttendanceLeave();
		$leave->from_date = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
		$leave->to_date = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
		$leave->remarks = $request->remarks;

		$leave->person()->associate($modelInstance);
		$leave->save();

		return redirect('attendance-leave')->with([
			'toastrmsg' => [
				'type' => 'success',
				'title' => 'Attendance Leave',
				'msg' => 'Registration Successful',
			],
		]);
	}
}
