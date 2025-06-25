<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" width="48px" height="48px" class="img-circle"
                            src="{{ URL::to('img/avatar.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong
                                    class="font-bold text-capitalize">{{ Auth::user()->role }}</strong>
                            </span> <span class="text-muted text-xs block text-capitalize">{{ Auth::user()->name }}<b
                                    class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ URL('user-settings') }}"><span class="fa fa-gear fa-spin"></span> User
                                Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL('logout') }}"><span class="fa fa-sign-out"></span> Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    SMS
                </div>
            </li>
            <li class="{{ isActiveRoute('dashboard') }}">
                <a href="{{ URL('dashboard') }}" data-root="dashboard"><i class="fa fa-th-large"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{ isActiveRoute('students.index') }}">
                <a href="{{ route('students.index') }}" data-root="{{ Route::currentRouteName() }}"><i
                        class="fa fa-group"></i> <span class="nav-label"></span>Students</a>
            </li>
            <li class="{{ isActiveRoute('teacher.index') }}">
                <a href="{{ route('teacher.index') }}" data-root=""><i class="entypo-users"></i> <span
                        class="nav-label"></span>Teachers</a>
            </li>
            <li class="{{ isActiveRoute('employee.index') }}">
                <a href="{{ route('employee.index') }}" data-root=""><i class="fa fa-user-circle-o"></i> <span
                        class="nav-label"></span>Employees</a>
            </li>
            <li class="{{ isActiveRoute('guardian.index') }}">
                <a href="{{ route('guardian.index') }}" data-root=""><i class="fa fa-user"></i> <span
                        class="nav-label"></span>Guardians</a>
            </li>
            <li class="{{ isActiveRoute('manage-*') }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Class</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('manage-classes.index') }}" data-show="">
                        <a href="{{ route('manage-classes.index') }}">Manage Classes</a>
                    </li>
                    <li class="{{ isActiveRoute('manage-sections.index') }}" data-show="">
                        <a href="{{ route('manage-sections.index') }}">Manage Sections</a>
                    </li>
                </ul>
            </li>
            <li class="{{ isActiveRoute(['vendors.index', 'items.index', 'vouchers.index']) }}">
                <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Inventory</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('vendors.index') }}" data-show="">
                        <a href="{{ route('vendors.index') }}">Vendors</a>
                    </li>
                    <li class="{{ isActiveRoute('items.index') }}" data-show="">
                        <a href="{{ route('items.index') }}">Items</a>
                    </li>
                    <li class="{{ isActiveRoute('vouchers.index') }}" data-show="">
                        <a href="{{ route('vouchers.index') }}">Vouchers</a>
                    </li>
                </ul>
            </li>
            <li class="{{ isActiveRoute('routines.index') }}">
                <a href="{{ route('routines.index') }}" data-root=""><i class="entypo-target"></i> <span
                        class="nav-label"></span>Class Routine</a>
            </li>
            <li class="{{ isActiveRoute('*attendance*') }}">
                <a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Daily Attendance</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('student-attendance.index') }}" data-show="">
                        <a href="{{ route('student-attendance.index') }}">Student Attendance</a>
                    </li>
                    <li class="{{ isActiveRoute('teacher-attendance.index') }}" data-show="">
                        <a href="{{ route('teacher-attendance.index') }}">Teacher Attendance</a>
                    </li>
                    <li class="{{ isActiveRoute('employee-attendance.index') }}" data-show="">
                        <a href="{{ route('employee-attendance.index') }}">Employee Attendance</a>
                    </li>
                </ul>
            </li>
            <li class="{{ isActiveRoute('manage-subjects.index') }}">
                <a href="{{ route('manage-subjects.index') }}" data-root=""><i class="entypo-docs"></i> <span
                        class="nav-label"></span>Subjects</a>
            </li>
            <li class="{{ isActiveRoute('student-migrations.index') }}">
                <a href="{{ route('student-migrations.index') }}" data-root=""><i
                        class="glyphicon glyphicon-transfer"></i> <span class="nav-label"></span>Student
                    Migrations</a>
            </li>
            <li class="{{ isActiveRoute('exam*') }}">
                <a href="#"><i class="fa fa-graduation-cap"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Exam</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('exam.index') }}" data-show="">
                        <a href="{{ route('exam.index') }}">Exam</a>
                    </li>
                    <li class="{{ isActiveRoute('manage-result.index') }}" data-show="">
                        <a href="{{ route('manage-result.index') }}">Manage Result</a>
                    </li>
                </ul>
            </li>
            <li class="{{ isActiveRoute('library.index') }}">
                <a href="{{ route('library.index') }}" data-root=""><i class="fa fa-book"></i> <span
                        class="nav-label"></span>Library</a>
            </li>
            <li class="{{ isActiveRoute('noticeboard.index') }}">
                <a href="{{ route('noticeboard.index') }}" data-root=""><i class="fa fa-clipboard"></i> <span
                        class="nav-label"></span>Noticeboard</a>
            </li>
            <li class="{{ isActiveRoute(['fee.index', 'expense.index']) }}">
                <a href="#"><i class="entypo-suitcase"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Accounting</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('fee.index') }}" data-show="">
                        <a href="{{ route('fee.index') }}">Fee</a>
                    </li>
                    <li class="{{ isActiveRoute('expense.index') }}" data-show="">
                        <a href="{{ route('expense.index') }}">Expense</a>
                    </li>
                </ul>
            </li>
            <li class="{{ isActiveRoute('smsnotifications.index') }}">
                <a href="{{ route('smsnotifications.index') }}" data-root=""><i class="fa fa-paper-plane"></i>
                    <span class="nav-label"></span>SMS Notifications</a>
            </li>
            <li class="{{ isActiveRoute(['seatsreport', '*reports*']) }}">
                <a href="#"><i class="fa fa-file"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Report</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('seatsreport') }}" data-show="">
                        <a href="{{ route('seatsreport') }}">Seats Report</a>
                    </li>
                    <li class="{{ isActiveRoute('fee-collection-reports.index') }}" data-show="">
                        <a href="{{ route('fee-collection-reports.index') }}">Fee Collection</a>
                    </li>
                    <li class="{{ isActiveRoute('exam-reports.index') }}" data-show="">
                        <a href="{{ route('exam-reports.index') }}">Exam reports</a>
                    </li>
                </ul>
            </li>
            <li
                class="{{ isActiveRoute(['users.index', 'roles.index', 'system-setting.index', 'fee-scenario.index', 'exam-grades.index']) }}">
                <a href="#"><i class="fa fa-gear fa-spin"></i> <span class="nav-label"></span><span
                        class="fa arrow"></span>Administrative Tools</a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ isActiveRoute('users.index') }}" data-show="">
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="{{ isActiveRoute('roles.index') }}" data-show="">
                        <a href="{{ route('roles.index') }}">Roles</a>
                    </li>
                    <li class="{{ isActiveRoute('system-setting.index') }}" data-show="">
                        <a href="{{ route('system-setting.index') }}">System Setting</a>
                    </li>
                    <li class="{{ isActiveRoute('fee-scenario.index') }}" data-show="">
                        <a href="{{ route('fee-scenario.index') }}">Fee Scenario</a>
                    </li>
                    <li class="{{ isActiveRoute('exam-grades.index') }}" data-show="">
                        <a href="{{ route('exam-grades.index') }}">Exam Grades</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
