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
				AttendanceLeave::with('person')->select('person_type', 'person_id' , 'from_date', 'to_date', 'remarks')
			)
			->addColumn('name', function ($row) {
				$person = $row->person;
				return $person?->name ?? '-';
			})
			->editColumn('person_type', function ($row) {
				return class_basename($row->person_type);
			})
			->make(true);
		}

		
		$data['classStudents'] = Classe::with('Students')->get()->map(fn($classe) => [
			'id' => $classe->id,
			'class_name' => $classe->name,
			'students' => $classe->students->map(fn($student) => [
				'id' => $student->id,
				'name' => $student->name,
				'gr_no' => $student->gr_no
			])
		]);
		$data['teachers'] = Teacher::select('id', 'name')->get();
		$data['employees'] = Employee::NotDeveloper()->select('id', 'name')->get();

		
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
