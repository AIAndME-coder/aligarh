@php use Illuminate\Support\Str; @endphp
@extends('admin.layouts.master')

@section('title', 'Attendance Leave |')

@section('head')
    <link href="{{ URL::to('src/css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var sections = {!! json_encode($sections ?? '') !!};
        var students = {!! json_encode($students ?? '') !!};
    </script>
    <style type="text/css">
        .print-table {
            width: 100%;
        }

        .print-table th,
        .print-table td {
            border: 1px solid black !important;
            padding: 0px;
        }

        .print-table>tbody>tr>td {
            padding: 1px;
        }

        .print-table>thead>tr>th {
            padding: 3px;
        }
    </style>
@endsection

@section('content')
    @include('admin.includes.side_navbar')

    <div id="page-wrapper" class="gray-bg">

        @include('admin.includes.top_navbar')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8 col-md-6">
                <h2>Attendance Leaves</h2>
                <ol class="breadcrumb">
                    <li>Home</li>
                    <li Class="active">
                        <a>Attendance Leaves</a>
                    </li>
                </ol>
            </div>
            <div class="col-lg-4 col-md-6">
                @include('admin.includes.academic_session')
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="">
                                <a data-toggle="tab" href="#tab-10"><span class="fa fa-list"></span> Attendance Leave</a>
                            </li>
                            @can('roles.create')
                                <li class="add-role">
                                    <a data-toggle="tab" href="#tab-11"><span class="fa fa-plus"></span> Make Attendance
                                        Leave</a>
                                </li>
                            @endcan
                        </ul>
                        <div class="tab-content">
                            <div id="tab-10" class="tab-pane fade">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-role">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>From Date</th>
                                                    <th>To Date</th>
                                                    <th>Remarks</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @can('roles.create')
                                <div id="tab-11" class="tab-pane fade make-attendance">
                                    <div class="panel-body" style="min-height: 400px">
                                        <h2> Make Attendance </h2>
                                        <div class="hr-line-dashed"></div>
                                        <form method="post" id="mk_att_frm" action="{{ route('attendance-leave.make') }}"
                                            class="form-horizontal jumbotron" role="form">
                                            @csrf
                                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Type </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" v-model="type"
                                                        @change="handleTypeChange" name="type" required="true">
                                                        <option value="{{ 'student' }}">{{ 'Student' }}</option>
                                                        <option value="{{ 'teacher' }}">{{ 'Teacher' }}</option>
                                                        <option value="{{ 'employee' }}">{{ 'Employee' }}</option>
                                                    </select>
                                                    @if ($errors->has('class'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('class') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div v-show="type == 'student'"
                                                class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Class </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="class"
                                                        :required="type === 'student'">
                                                        <option value="" disabled selected>Class</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('class'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('class') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div v-show="type == 'student'"
                                                class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label">Section</label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="section">
                                                        <option value="" :required="type === 'student'" disabled
                                                            selected>Select Section</option>
                                                    </select>
                                                    @if ($errors->has('section'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('section') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div v-show="type == 'student'"
                                                class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Students </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="student"
                                                        :required="type === 'student'">
                                                        <option value="" disabled selected>--Select--</option>
                                                    </select>
                                                    @if ($errors->has('student'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('class') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div v-if="type == 'teacher'"
                                                class="form-group{{ $errors->has('person_id') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Teacher </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="person_id"
                                                        :required="type === 'teacher'">
                                                        <option value="" disabled selected>--Select--</option>
                                                        @foreach ($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('person_id'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('person_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div v-if="type == 'employee'"
                                                class="form-group{{ $errors->has('person_id') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Employee </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="person_id"
                                                        :required="type === 'employee'">
                                                        <option value="" disabled selected>--Select--</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('person_id'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('person_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group{{ $errors->has('from_date') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label">From Date </label>
                                                <div class="col-md-6">
                                                    <input id="from_datetimepicker" type="text" name="from_date"
                                                        class="form-control" placeholder="From Date"
                                                        value="{{ old('from_date') }}" required="true" autocomplete="off">
                                                    @if ($errors->has('from_date'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('from_date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('to_date') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> To Date </label>
                                                <div class="col-md-6">
                                                    <input id="to_datetimepicker" type="text" name="to_date"
                                                        class="form-control" placeholder="To Date"
                                                        value="{{ old('to_date') }}" required="true" autocomplete="off">
                                                    @if ($errors->has('to_date'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('to_date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Remarks </label>
                                                <div class="col-md-6">
                                                    <textarea name="remarks" required="true" class="form-control" rows="4" value="{{ old('remarks') }}" required
                                                        ref="messageBox"></textarea>
                                                    @if ($errors->has('remarks'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('remarks') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-md-6">
                                                    <button class="btn btn-primary" type="submit">
                                                        <span class="glyphicon glyphicon-save"></span>
                                                        Make Attendance
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endcan
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
    <script src="{{ URL::to('src/js/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('src/js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Validation Error");
            @endforeach
        </script>
    @endif

    <script type="text/javascript">
        var tbl;

        function select2template(data) {
            if (!data.id) {
                return data.text;
            }
            var $data = $(
                data.htm1 + data.text + data.htm2
            );
            return $data;
        };

        function loadOptions(data, type, full, meta) {
            opthtm = '';
            @can('roles.update')
                opthtm = '<a href="{{ URL('roles/edit') }}/' + full.id +
                    '" data-toggle="tooltip" title="Edit" class="btn btn-';
                opthtm += ' btn-circle btn-xs edit-option"><span class="fa fa-edit"></span></a>';
            @endcan
            return opthtm;
        }

        $(document).ready(function() {

            


            tbl = $('.dataTables-role').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '12px');
                        $(win.document.body).find('table')
                            .addClass('print-table')
                            .removeClass('table')
                            .removeClass('table-striped')
                            .removeClass('table-bordered')
                            .removeClass('table-hover')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    title: "roles | {{ config('systemInfo.general.title') }}",
                }],
                Processing: true,
                serverSide: true,
                ajax: '{{ URL('attendance-leave') }}',
                columns: [{
                        data: 'person_type'
                    },
                    {
                        data: 'from_date'
                    },
                    {
                        data: 'to_date'
                    },
                    {
                        data: 'remarks'
                    },
                    {
                        render: loadOptions,
                        className: 'hidden-print',
                        "orderable": false
                    },
                ],
            });

            $(".dataTables-role tbody").on('mouseenter', "[data-toggle='tooltip']", function() {
                $(this).tooltip('show');
            });

            // $('[name="class"]').on('change', function(){
            //     console.log(454);
            //     clsid = $(this).val();
            //     $('[name="class"]').val(clsid);
            //     $('[name="section"]').html('<option></option>');
            //     if(sections['class_'+clsid].length > 0 && clsid > 0){          
            //         $.each(sections['class_'+clsid], function(k, v){
            //         $('[name="section"]').append('<option value="'+v['id']+'">'+v['name']+'</option>');
            //         });
            //     }
            // });

            $('[name="class"]').on('change', function() {
                var clsid = $(this).val();
                $('[name="class"]').val(clsid);
                $('[name="section"]').html('<option value="" disabled selected>Select Section</option>');
                $('[name="student"]').html(
                    '<option value="" disabled selected>--Select--</option>'
                    ); // Clear students on class change

                if (sections['class_' + clsid] && sections['class_' + clsid].length > 0) {
                    $.each(sections['class_' + clsid], function(k, v) {
                        $('[name="section"]').append('<option value="' + v['id'] + '">' + v[
                            'name'] + '</option>');
                    });
                }
            });

            // When section is selected, filter and show students
            $('[name="section"]').on('change', function() {
                var clsid = $('[name="class"]').val();
                var sectionId = $(this).val();

                $('[name="student"]').html(
                    '<option value="" disabled selected>--Select--</option>'); // Clear students first

                if (clsid && sectionId) {
                    $.each(students, function(k, v) {
                        if (v.class_id == clsid && v.section_id == sectionId) {
                            $('[name="student"]').append('<option value="' + v.id + '">' + v.name +
                                '</option>');
                        }
                    });
                }
            });

            $('#to_datetimepicker').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate: moment(),
            });
            $('#from_datetimepicker').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate: moment(),
            });

            $("#tchr_rgstr").validate({
                ignore: ":not(:visible)",
                rules: {
                    name: {
                        required: true,
                    },
                    teacher: {
                        required: true,
                    }
                }
            });

            @if (COUNT($errors) >= 1 && !$errors->has('toastrmsg'))
                $('#mk_att_frm [name="class"]').val("{{ old('class') }}");
                $('[name="class"]').change();
                $('[name="section"]').val('{{ old('section') }}');
            @elseif (isset($input) && $input !== null)
                $('#mk_att_frm [name="class"]').val("{{ $input['class'] }}");
                $('[name="class"]').change();
                $('[name="section"]').val("{{ $input['section'] }}");

                $('#mk_att_frm [name="date"]').val("{{ $input['date'] }}");
            @endif

            @if (collect($errors)->count() >= 1 && !$errors->has('toastrmsg'))
                $('a[href="#tab-10"]').tab('show');
            @else
                $('a[href="#tab-11"]').tab('show');
            @endif
        });
    </script>
@endsection

@section('vue')
    <script type="text/javascript">
        var app = new Vue({
            el: "#app",
            data() {
                return {
                    type: '',
                };
            },
            methods: {
                handleTypeChange() {
                    console.log("Selected type changed to:", this.type);
                },
            },

            computed: {

            }
        });
    </script>
@endsection
