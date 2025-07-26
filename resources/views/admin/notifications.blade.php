@extends('admin.layouts.master')

@section('title', 'Notifications |')

@section('head')
    <link href="{{ URL::to('src/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('admin.includes.side_navbar')
    <div id="page-wrapper" class="gray-bg">
        @include('admin.includes.top_navbar')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8 col-md-6">
                <h2>Notifications</h2>
                <ol class="breadcrumb">
                    <li>Home</li>
                    <li class="active"><a>Send</a></li>
                </ol>
            </div>
            <div class="col-lg-4 col-md-6">
                @include('admin.includes.academic_session')
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h2>Messsage Send</h2>
                        </div>
                        <div class="ibox-content">
                            <form id="notification" method="post" action="{{ route('notifications.send') }}"
                                class="form-horizontal">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="type">Type</label>
                                    <div class="col-sm-8">
                                        <select name="type" id="type" class="form-control" v-model="type"
                                            @change="handleTypeChange" required>
                                            <option value="">-- Select Type --</option>
                                            <option value="students">Student</option>
                                            <option value="guardians">Guardian</option>
                                            <option value="teachers">Teacher</option>
                                            <option value="employees">Employee</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="type === 'students'" class="form-group">
                                    <label class="col-sm-2 control-label">Students</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" v-model="selectedId"
                                            @change="onSelectionChangeStudents" required>
                                            <option value="">-- Select Class or Student --</option>
                                            <optgroup v-for="(group, index) in studentsByClass" :key="index"
                                                :label="group.class_name">
                                                <option :value="'class_' + group.id">[Select Class: @{{ group.class_name }}]
                                                </option>
                                                <option v-for="student in group.students" :value="'student_' + student.id"
                                                    :key="student.id">
                                                    @{{ student.name }}
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="type == 'guardians'" class="form-group">
                                    <label class="col-sm-2 control-label" for="type">Guardian</label>
                                    <div class="col-sm-8">
                                        <select name="selected_guardian_id" v-model="selectedGuardianId" id="guardians"
                                            class="form-control" required>
                                            <option selected value="">-- Select --</option>
                                            <option value="all">-- All --</option>
                                            <option v-for="guardian in guardians" :value="guardian.id">
                                                @{{ guardian.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="type == 'teachers'" class="form-group">
                                    <label class="col-sm-2 control-label" for="type">Teachers</label>
                                    <div class="col-sm-8">
                                        <select name="type" id="teachers" class="form-control" v-model="type" required>
                                            <option value="">-- Select --</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="type == 'employees'" class="form-group">
                                    <label class="col-sm-2 control-label" for="type">Employees</label>
                                    <div class="col-sm-8">
                                        <select name="type" id="employees" class="form-control" v-model="type" required>
                                            <option value="">-- Select --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8" style="margin-bottom: 10px;">
                                        <template v-if="tokenMap[type]">
                                            <span class="label label-info" style="cursor:pointer;"
                                                @click="insertToken(tokenMap[type])">
                                                @{{ tokenMap[type] }}
                                            </span>
                                        </template>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Message</label>
                                    <div class="col-sm-8">
                                        <textarea name="message" class="form-control" v-model="message" rows="4" required ref="messageBox"></textarea>
                                        <small class="text-muted">
                                            You can use <code>{name}</code> in your message. It will be replaced
                                            automatically.
                                        </small>
                                    </div>
                                    <input type="hidden" v-model="type" name="type" />
                                    <input v-if="type === 'students'" type="hidden" v-model="selectedStudentId"
                                        name="selected_student_id" />
                                    <input v-if="type === 'students'"type="hidden" v-model="selectedClassId"
                                        name="selected_class_id" />
                                    <input type="hidden" v-model="message" name="message" />

                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6">
                                        <button class="btn btn-primary" type="submit">
                                            <span class="glyphicon glyphicon-send"></span> Send
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Mainly scripts -->
    <script src="{{ URL::to('src/js/plugins/jeditable/jquery.jeditable.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/axios-1.11.0/axios.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Validation Error");
            @endforeach
        </script>
    @endif
@endsection

@section('vue')
    <script type="text/javascript">
        var app = new Vue({
            el: "#app",
            data() {
                return {
                    type: '',
                    message: '',
                    studentsByClass: [],
                    guardians: [],
                    teachers: [],
                    employees: [],
                    selectedType: '',
                    selectedClassName: '',
                    selectedStudent: null,
                    selectedId: '',
                    selectedClassId: '',
                    selectedStudentId: '',
                    selectedGuardianId: '',

                    // tokens
                    tokenMap: {
                        students: '{student_name}',
                        teachers: '{teacher_name}',
                        guardians: '{guardian_name}',
                        employees: '{employee_name}',
                    },

                };
            },
            methods: {
                handleTypeChange() {
                    this.getData();
                    console.log("Selected type changed to:", this.type);
                },
                getData() {
                    axios.post('/notifications/get/data', {
                            type: this.type
                        })
                        .then(response => {
                            const res = response.data;
                            switch (this.type) {
                                case 'students':
                                    this.studentsByClass = response.data;
                                    break;
                                case 'teachers':
                                    this.teachers = response.data;
                                    break;
                                case 'guardians':
                                    this.guardians = response.data;
                                    console.log(this.guardians);

                                    break;
                                case 'employees':
                                    this.employees = response.data;
                                    break;
                            }
                        })
                        .catch(error => {
                            console.error('Failed to fetch', error);
                        });
                },
                onSelectionChangeStudents() {
                    if (this.selectedId.startsWith('class_')) {
                        const classId = parseInt(this.selectedId.replace('class_', ''));
                        const selectedClass = this.studentsByClass.find(c => c.id === classId);

                        this.selectedType = 'class';
                        this.selectedClassId = classId;
                        this.selectedClassName = selectedClass?.class_name || '';
                        this.selectedStudent = null;

                        // console.log('Selected Class:', this.selectedClassName, 'ID:', this.selectedClassId);

                    } else if (this.selectedId.startsWith('student_')) {
                        const studentId = parseInt(this.selectedId.replace('student_', ''));
                        for (let group of this.studentsByClass) {
                            const student = group.students.find(s => s.id === studentId);
                            if (student) {
                                this.selectedType = 'student';
                                this.selectedStudent = student;
                                this.selectedClassId = null;
                                this.selectedClassName = '';
                                this.selectedStudentId = student.id;
                                // console.log('Selected Student:', student.name, 'ID:', student.id);
                                break;
                            }
                        }
                    } else {
                        // Reset all
                        this.selectedType = '';
                        this.selectedClassId = null;
                        this.selectedClassName = '';
                        this.selectedStudent = null;
                    }
                },
                insertToken(token) {
                    const textarea = this.$refs.messageBox;

                    if (textarea) {
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const before = this.message.substring(0, start);
                        const after = this.message.substring(end);
                        this.message = before + token + after;
                        this.$nextTick(() => {
                            textarea.focus();
                            textarea.selectionStart = textarea.selectionEnd = start + token.length;
                        });
                    }
                }
            }
        });
    </script>
@endsection
