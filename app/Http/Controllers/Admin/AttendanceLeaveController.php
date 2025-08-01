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
				AttendanceLeave::with('person')->select('id', 'person_type', 'person_id', 'from_date', 'to_date', 'remarks')
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
				'type' => 'required|in:Student,Teacher,Employee',
				'from_date' => 'required|date|date_format:Y-m-d',
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
			'Student' => Student::class,
			'Teacher' => Teacher::class,
			'Employee' => Employee::class,
		];

		$modelClass = $modelMap[$request->type] ?? null;
		if (!$modelClass) {
			return redirect()->back()->withErrors(['type' => 'Invalid type']);
		}

		$modelInstance = $modelClass::findOrFail($request->person_id);

		$leave = new AttendanceLeave();
		$leave->from_date = $request->from_date;
		$leave->to_date = $request->to_date;
		$leave->remarks = $request->remarks;

		$leave->person()->associate($modelInstance);
		$leave->save();

		$personModel = $leave->person;
		$this->updateLeaveId($personModel, $leave->from_date, $leave->to_date, $leave->id);

		return redirect('attendance-leave')->with([
			'toastrmsg' => [
				'type' => 'success',
				'title' => 'Attendance Leave',
				'msg' => 'Registration Successful',
			],
		]);
	}


	public function Edit($id)
	{
		$data['attendanceLeave'] = AttendanceLeave::with('person')->findOrFail($id);
		return view('admin.edit_attendance_leave', $data);
	}


	public function Update(Request $request, $id)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'from_date' => 'required|date|date_format:Y-m-d',
				'to_date' => 'required|after_or_equal:from_date',
				'remarks' => 'required',
			],
			[
				'from_date.required' => 'From Date is required',
				'to_date.required' => 'To Date is required',
				'to_date.after_or_equal' => 'The to date must be after or equal to from date.',
				'remarks.required' => 'Remarks is required',
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


		$attendanceLeave = AttendanceLeave::findOrFail($id);

		if ($attendanceLeave->from_date !== $request->input('from_date') && $attendanceLeave->to_date !== $request->input('to_date')) {

			$personModel = $attendanceLeave->person;

			//leave_id null and update new one 
			$this->updateLeaveId($personModel, $attendanceLeave->from_date, $attendanceLeave->to_date);
			$this->updateLeaveId($personModel, $request->from_date, $request->to_date, $id);

			$attendanceLeave->Update([
				'from_date' => $request->from_date,
				'to_date' => $request->to_date,
				'remarks' => $request->remarks
			]);
		} else {
			$attendanceLeave->Update([
				'remarks' => $request->remarks
			]);
		}

		return redirect('attendance-leave')->with([
			'toastrmsg' => [
				'type' => 'success',
				'title' => 'Attendance Leave',
				'msg' => 'Successful Update',
			],
		]);
	}

	public function Delete(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'id' => 'required|exists:attendance_leaves,id',
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
						'msg' => 'There was an issue while Deleting Attendance Leave',
					],
				]);
		}

		$attendanceLeave = AttendanceLeave::find($request->input('id'));

		$personModel = $attendanceLeave->person;

		//leave_id null 
		$this->updateLeaveId($personModel, $attendanceLeave->from_date, $attendanceLeave->to_date);
		$attendanceLeave->delete();

		return redirect('attendance-leave')->with([
			'toastrmsg' => [
				'type' => 'success',
				'title' => 'Attendance Leave',
				'msg' => 'Deleted Successfully',
			],
		]);
	}


	private function updateLeaveId($personModel, $fromDate, $toDate, $leaveId = null)
	{
		$personModel->attendances()
			->where('date', '>=', $fromDate)->where('date', '<=', $toDate)
			->update(['leave_id' => $leaveId]);
	}
}
