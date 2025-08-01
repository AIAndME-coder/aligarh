@php use Illuminate\Support\Str; @endphp
@extends('admin.layouts.master')

@section('title', 'Attendance Leave |')

@section('head')
    <link href="{{ URL::to('src/css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('src/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
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
                                                    <th>Name</th>
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
                                                    <select class="form-control select2" v-model="type" name="type" required="true">
                                                        <option value="">{{ '--- Select Type ---' }}</option>
                                                        <option value="{{ 'Student' }}">{{ 'Student' }}</option>
                                                        <option value="{{ 'Teacher' }}">{{ 'Teacher' }}</option>
                                                        <option value="{{ 'Employee' }}">{{ 'Employee' }}</option>
                                                    </select>
                                                    @if ($errors->has('class'))
                                                        <span class="help-block">
                                                            <strong><span class="fa fa-exclamation-triangle"></span>
                                                                {{ $errors->first('class') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div v-show="type == 'Student'"
                                                class="form-group{{ $errors->has('person_id') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Student </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="person_id"
                                                        :required="type === 'Student'">
                                                        <option value="" disabled selected>-- Select Student --</option>
                                                        @foreach ($classStudents as $classStudent)
                                                            <optgroup label="{{ $classStudent['class_name'] }}">
                                                                @foreach ($classStudent['students'] as $student)
                                                                    <option value="{{ $student['id'] }}">
                                                                        {{ $student['name'] }} | {{ $student['gr_no'] }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
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


                                            <div v-if="type == 'Teacher'"
                                                class="form-group{{ $errors->has('person_id') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Teacher </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="person_id"
                                                        :required="type === 'Teacher'">
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

                                            <div v-if="type == 'Employee'"
                                                class="form-group{{ $errors->has('person_id') ? ' has-error' : '' }}">
                                                <label class="col-md-2 control-label"> Employee </label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" name="person_id"
                                                        :required="type === 'Employee'">
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
                                                    <textarea name="remarks" required class="form-control" rows="4" ref="messageBox">{{ old('remarks') }}</textarea>
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
                                                        Make Attendance Leave
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
    <script src="{{ URL::to('src/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
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
            var $data = $(data.htm1 + data.text + data.htm2);
            return $data;
        }

        function loadOptions(data, type, full, meta) {
            let opthtm = '';
            @can('attendance-leave.update')
                opthtm += '<a href="{{ url('attendance-leave/edit') }}/' + full.id + '"';
                opthtm += ' data-toggle="tooltip" title="Edit"';
                opthtm += ' class="btn btn-primary btn-circle btn-xs edit-option">';
                opthtm += '<span class="fa fa-edit"></span></a>';
            @endcan
            @can('attendance-leave.delete')
                opthtm += '<button type="button" class="btn btn-danger btn-circle btn-xs delete-btn"';
                opthtm += ' data-toggle="tooltip" title="Delete" data-id="' + full.id + '">';
                opthtm += '<span class="fa fa-trash"></span></button>';
            @endcan
            return opthtm;
        }

        $(document).ready(function() {
            tbl = $('.dataTables-role').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                    extend: 'print',
                    title: "roles | {{ config('systemInfo.general.title') }}",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg').css('font-size', '12px');
                        $(win.document.body).find('table')
                            .addClass('print-table compact')
                            .removeClass('table table-striped table-bordered table-hover')
                            .css('font-size', 'inherit');
                    }
                }],
                processing: true,
                serverSide: true,
                ajax: '{{ url('attendance-leave') }}',
                columns: [{
                        data: 'name'
                    },
                    {
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
                        className: 'hidden-print text-center',
                        orderable: false
                    }
                ]
            });


            $('.dataTables-role tbody').on('click', '.delete-btn', function() {
                var deleteId = $(this).data('id');

                swal({
                        title: "Are you sure?",
                        text: "You are about to delete this entry.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: "Deleting...",
                                text: "<i class='fa fa-spinner fa-pulse fa-4x'></i>",
                                html: true,
                                showConfirmButton: false
                            });

                            $.post("{{ url('attendance-leave/delete') }}", {
                                    id: deleteId,
                                    _token: "{{ csrf_token() }}"
                                })
                                .done(function(data) {
                                    tbl.ajax.reload(null, false); // Reload table data without reset
                                    swal("Deleted!", "Record has been deleted.", "success");
                                })
                                .fail(function() {
                                    swal("Error!", "Something went wrong. Please try again.",
                                        "error");
                                });

                        } else {
                            swal("Cancelled", "The record is safe :)", "error");
                        }
                    });
            });




            $(".dataTables-role tbody").on('mouseenter', "[data-toggle='tooltip']", function() {
                $(this).tooltip('show');
            });

            $('#to_datetimepicker, #from_datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: moment()
            });

            $("#mk_att_frm").validate({
                ignore: ":not(:visible)",
                rules: {
                    type: {
                        required: true
                    },
                    to_date: {
                        required: true
                    },
                    from_date: {
                        required: true
                    }
                }
            });

            @if ($errors->any())
                $('a[href="#tab-11"]').tab('show');
            @else
                $('a[href="#tab-10"]').tab('show');
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
            },

            computed: {
            }
        });
    </script>
@endsection
