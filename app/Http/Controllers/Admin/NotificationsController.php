<?php

namespace App\Http\Controllers\Admin;


use App\Classe;
use App\Student;
use App\Teacher;
use App\Employee;
use App\Guardian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\NotificationSendMsgJob;
use Illuminate\Support\Facades\Validator;

class NotificationsController extends Controller
{
    protected $noficationType = [
        'Mail' => 'mail',
        'Sms' => 'sms',
        'Whatsapp' => 'whatsapp'
    ];
    public function index(Request $request)
    {


        return view('admin.notifications');
    }

    public function getData(Request $request)
    {
        switch ($request->input('type')) {
            case 'students':
                $data = Classe::with('Students')->get()->map(function ($classe) {
                    return [
                        'id' => $classe->id,
                        'class_name' => $classe->name,
                        'students' => $classe->students->map(function ($student) {
                            return [
                                'id' => $student->id,
                                'name' => $student->name
                            ];
                        })
                    ];
                });
                break;
            case 'teachers':
                $data = Teacher::all();
                break;
            case 'guardians':
                $data = Guardian::all();
                break;
            case 'employees':
                $data = Employee::all();
                break;
            default:
                return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        return response()->json($data);
    }

    public  function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'type' => 'required|in:students,teachers,guardians,employees',
            'selected_class_id' => 'nullable|exists:classes,id',
            'selected_student_id' => 'nullable|exists:students,id',
            'selected_guardian_id' => [
                'nullable',
                fn($attribute, $value, $fail) => $value !== null && $value !== 'all' && !Guardian::where('id', $value)->exists()
                    ? $fail('The selected guardian ID is invalid.')
                    : null,
            ],
        ]);

        if ($request->input('type') === 'guardians' && is_null($request->input('selected_guardian_id'))) {
            $validator->after(fn($validator) => $validator->errors()->add('selected_guardian_id', 'Plese select a guardian to send the message.'));
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $message = $request->input('message');
        $type = $request->input('type');
        $classId = $request->input('selected_class_id');
        $studentId = $request->input('selected_student_id');
        $guardianId = $request->input('selected_guardian_id');

        switch ($type) {
            case 'students':
                if ($studentId) {
                    $student = Student::with('Guardian:id,email')->find($studentId);
                    if ($student) {
                        $personalMessage = str_replace('{student_name}', $student->name, $message);

                        //NotificationSendMsgJob 
                        NotificationSendMsgJob::dispatch($student->Guardian->email, $student->Guardian->phone, $student->Guardian->phone, $personalMessage);
                        return $this->returnNotifications();
                    }
                } elseif ($classId) {
                    $students = Student::with('Guardian:id,email')->where('class_id', $classId)->get();

                    if ($students) {
                        foreach ($students as $student) {
                            $personalMessage = str_replace('{student_name}', $student->name, $message);

                            //NotificationSendMsgJob
                            NotificationSendMsgJob::dispatch($student->Guardian->email, $student->Guardian->phone, $student->Guardian->phone, $personalMessage);
                        }
                        return $this->returnNotifications();
                    }
                }

                break;
            case 'teachers':
                $teachers = Teacher::all();
                foreach ($teachers as $teacher) {
                    // Send $message to $teacher
                }
                break;
            case 'guardians':
                if ($guardianId === 'all') {
                    $guardians = Guardian::all();
                    foreach ($guardians as $guardian) {
                        $personalMessage = str_replace('{guardian_name}', $guardian->name, $message);
                        // e.g. NotificationSendMsgJob 
                        NotificationSendMsgJob::dispatch($guardian->Guardian->email, $guardian->phone, $guardian->phone, $personalMessage);
                    }

                    return $this->returnNotifications();
                } else {
                    $guardian = Guardian::find($guardianId);
                    $personalMessage = str_replace('{guardian_name}', $guardian->name, $message);

                    // e.g. NotificationSendMsgJob 
                    NotificationSendMsgJob::dispatch($guardian->Guardian->email, $guardian->phone, $guardian->phone, $personalMessage);
                    return $this->returnNotifications();
                }
                break;
            case 'employees':
                $employees = Employee::all();
                foreach ($employees as $employee) {
                    // Send $message to $employee
                }

                break;
            default:
                return redirect()->back()
                    ->withInput()
                    ->with([
                        'toastrmsg' => [
                            'type' => 'error',
                            'title' => 'Error',
                            'msg' => 'There was an issue while Sending Notification'
                        ]
                    ]);
        }
    }


    private function returnNotifications()
    {
        return redirect('notifications')->with([
            'toastrmsg' => [
                'type' => 'success',
                'title'  =>  'Message Send',
                'msg' =>  'Messages sent to successfully'
            ]
        ]);
    }
}
