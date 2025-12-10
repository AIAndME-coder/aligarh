<?php

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if you want to name the related pivots other than defaults
         */
        'role_pivot_key' => null, // default 'role_id',
        'permission_pivot_key' => null, // default 'permission_id',

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use the teams feature and your related model's
         * foreign key is other than `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false if you want to implement custom logic for checking permissions.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true, Laravel\Octane\Events\OperationTerminated event listener will be registered
     * this will refresh permissions on every TickTerminated, TaskTerminated and RequestTerminated
     * NOTE: This should not be needed in most cases, but an Octane/Vapor combination benefited from it.
     */
    'register_octane_reset_listener' => false,

    /*
     * Events will fire when a role or permission is assigned/unassigned:
     * \Spatie\Permission\Events\RoleAttached
     * \Spatie\Permission\Events\RoleDetached
     * \Spatie\Permission\Events\PermissionAttached
     * \Spatie\Permission\Events\PermissionDetached
     *
     * To enable, set to true, and then create listeners to watch these events.
     */
    'events_enabled' => false,

    /*
     * Teams Feature.
     * When set to true the package implements teams using the 'team_foreign_key'.
     * If you want the migrations to register the 'team_foreign_key', you must
     * set this to true before doing the migration.
     * If you already did the migration then you must make a new migration to also
     * add 'team_foreign_key' to 'roles', 'model_has_roles', and 'model_has_permissions'
     * (view the latest version of this package's migration file)
     */

    'teams' => false,

    /*
     * The class to use to resolve the permissions team id
     */
    'team_resolver' => \Spatie\Permission\DefaultTeamResolver::class,

    /*
     * Passport Client Credentials Grant
     * When set to true the package will use Passports Client to check permissions
     */

    'use_passport_client_credentials' => false,

    /*
     * When set to true, the required permission names are added to exception messages.
     * This could be considered an information leak in some contexts, so the default
     * setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to exception messages.
     * This could be considered an information leak in some contexts, so the default
     * setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     * See documentation to understand supported syntax.
     */

    'enable_wildcard_permission' => false,

    /*
     * The class to use for interpreting wildcard permissions.
     * If you need to modify delimiters, override the class and specify its name here.
     */
    // 'wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    /* Cache-specific settings */

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],

    'ignore_routes' => [
        'debugbar.openhandler',
        'debugbar.clockwork',
        'debugbar.assets.css',
        'debugbar.assets.js',
        'debugbar.cache.delete',
        'guardian.login',
        'tms.login',
        'login',
        'logout',
        'login.post',
        'notifications.log',
        'notifications.log.read',
        'system-setting.logo',
        'exam-reports.update.rank', // will update.
        
        // AJAX Data Endpoints (SELECT2/DROPDOWN)
        'students.guardians.list', // Fetch guardians for student form dropdown
        'teacher.find',             // Find teacher for select2
        'employee.find',            // Find employee for select2
        'student-migrations.get',   // Get students for migration
        'exam-reports.find.student',// Find student for exam reports
        'fee.findstu',              // Find student for fees
        
        // Image Endpoints (Profile/Avatar)
        'students.image',           // Return student image
        'teacher.image',            // Return teacher image
        'employee.image',           // Return employee image

        // Report/Print Endpoints (PDF)
        // 'fee.chalan.print',         // Print chalan PDF
        // 'fee.invoice.print',        // Print invoice PDF
        // 'fee.group.chalan.print',   // Print group chalan PDF
        // 'fee.bulk.print.invoice',   // Print bulk invoices PDF
        // 'students.card',            // Print student ID card
        
        // Note: These are currently in ignore list because:
        // - They return public/non-sensitive data
        // - They are AJAX helper endpoints for UI
        // - They don't modify data (GET requests)
        // - Future: Consider adding route names for full permission tracking
    ],

    'permissions' => [
        'Dashboard & Settings' => [
            'dashboard' => 'Dashboard',
            'dashboard.top_content' => 'Show Total Students, Teacher etc..',
            'dashboard.timeline' => 'Show TimeLins (Notice Board)',
            'dashboard.monthly_attendance' => 'Show Monthly Attendance',
            'dashboard.fee_Collection' => 'Show Fee Collection',
            'dashboard.monthly_expenses' => 'Show Monthly Expenses',
            'user-settings.index' => 'User Settings View',
            'user-settings.password.update' => 'Password Update',
            'user-settings.change.session' => 'Change Session',
        ],

        'Users' => [
            'users.index' => 'User View',
            'users.create' => [
                'label' => 'User Create',
                'dependencies' => ['users.index']
            ],
            'users.edit' => [
                'label' => 'User Edit',
                'dependencies' => ['users.index']
            ],
            'users.update' => [
                'label' => 'User Update',
                'dependencies' => ['users.index']
            ],
            'users.update.update_password' => 'Update Password (User Update)'
        ],

        'Roles' => [
            'roles.index' => 'Role View',
            'roles.create' => [
                'label' => 'Role Create',
                'dependencies' => ['roles.index']
            ],
            'roles.edit' => [
                'label' => 'Role Edit',
                'dependencies' => ['roles.index']
            ],
            'roles.update' => [
                'label' => 'Role update',
                'dependencies' => ['roles.index']
            ],
        ],

        'Students' => [
            'students.index' => 'Students View',
            'students.grid' => [
                'label' => 'Students Grid View',
                'dependencies' => ['students.index']
            ],
            'students.add' => [
                'label' => 'Students Create',
                'dependencies' => ['students.index']
            ],
            'students.edit' => [
                'label' => 'Students Edit',
                'dependencies' => ['students.index']
            ],
            'students.class_edit' => 'Edit Class',
            'students.edit.post' => [
                'label' => 'Students Update',
                'dependencies' => ['students.index']
            ],
            'students.profile' => [
                'label' => 'Students Profile',
                'dependencies' => ['students.index']
            ],
            'students.interview.get' => 'Interview View',
            'students.interview.update.create' => 'Interview Update',
            'students.certificate.get' => 'Certificate View',
            'students.certificate.create' => 'Certificate Create',
            'students.leave' => 'Students Leave',
        ],

        'Visitors' => [
            'visitors.index' => 'Visitors View',
            'visitors.grid' => [
                'label' => 'Visitors Grid View',
                'dependencies' => ['visitors.index']
            ],
            'visitors.profile' => [
                'label' => 'Visitors Profile',
                'dependencies' => ['visitors.index']
            ],
            'visitors.create' => [
                'label' => 'Visitors Create',
                'dependencies' => ['visitors.index']
            ],
            'students.show.visitor' => 'Show Admission Visitors',
            'students.create.visitor' => 'Create Admission Visitors',
            'visitors.edit' => [
                'label' => 'Visitors Edit',
                'dependencies' => ['visitors.index']
            ],
            'visitors.update' => [
                'label' => 'Visitors Update',
                'dependencies' => ['visitors.index']
            ],
            'visitors.delete' => [
                'label' => 'Visitors Delete',
                'dependencies' => ['visitors.index']
            ],
        ],

        'Teachers' => [
            'teacher.index' => 'Teachers View',
            'teacher.grid' => [
                'label' => 'Teachers Grid View',
                'dependencies' => ['teacher.index']
            ],
            'teacher.add' => [
                'label' => 'Teachers Create',
                'dependencies' => ['teacher.index']
            ],
            'teacher.edit' => [
                'label' => 'Teachers Edit',
                'dependencies' => ['teacher.index']
            ],
            'teacher.edit.post' => [
                'label' => 'Teachers Update',
                'dependencies' => ['teacher.index']
            ],
            'teacher.profile' => [
                'label' => 'Teachers Profile',
                'dependencies' => ['teacher.index']
            ],
        ],

        'Employees' => [
            'employee.index' => 'Employees View',
            'employee.grid' => [
                'label' => 'Employees Grid View',
                'dependencies' => ['employee.index']
            ],
            'employee.add' => [
                'label' => 'Employees Create',
                'dependencies' => ['employee.index']
            ],
            'employee.edit' => [
                'label' => 'Employees Edit',
                'dependencies' => ['employee.index']
            ],
            'employee.edit.post' => [
                'label' => 'Employees Update',
                'dependencies' => ['employee.index']
            ],
            'employee.profile' => [
                'label' => 'Employees Profile',
                'dependencies' => ['employee.index']
            ],
        ],

        'Guardians' => [
            'guardian.index' => 'Guardians View',
            'guardian.grid' => [
                'label' => 'Guardians Grid View',
                'dependencies' => ['guardian.index']
            ],
            'guardian.add' => [
                'label' => 'Guardians Create',
                'dependencies' => ['guardian.index']
            ],
            'guardian.edit' => [
                'label' => 'Guardians Edit',
                'dependencies' => ['guardian.index']
            ],
            'guardian.edit.post' => [
                'label' => 'Guardians Update',
                'dependencies' => ['guardian.index']
            ],
            'guardian.profile' => [
                'label' => 'Guardians Profile',
                'dependencies' => ['guardian.index']
            ],
        ],

        'Classes & Sections' => [
            'manage-classes.index' => 'Classes View',
            'manage-classes.add' => [
                'label' => 'Classes Create',
                'dependencies' => ['manage-classes.index']
            ],
            'manage-classes.edit' => 'Classes Edit',
            'manage-classes.edit.post' => [
                'label' => 'Classes Update',
                'dependencies' => ['manage-classes.index']
            ],
            'manage-sections.index' => 'Sections View',
            'manage-sections.add' => [
                'label' => 'Sections Create',
                'dependencies' => ['manage-sections.index']
            ],
            'manage-sections.edit' => 'Sections Edit',
            'manage-sections.edit.post' => [
                'label' => 'Sections Update',
                'dependencies' => ['manage-sections.index']
            ],
        ],

        'Subjects' => [
            'manage-subjects.index' => 'Subjects View',
            'manage-subjects.add' => [
                'label' => 'Subjects Create',
                'dependencies' => ['manage-subjects.index']
            ],
            'manage-subjects.edit' => [
                'label' => 'Subjects Edit',
                'dependencies' => ['manage-subjects.index']
            ],
            'manage-subjects.edit.post' => [
                'label' => 'Subjects Update',
                'dependencies' => ['manage-subjects.index']
            ],
        ],

        'Vendors & Items' => [
            'vendors.index' => 'Vendors View',
            'vendors.add' => [
                'label' => 'Vendors Create',
                'dependencies' => ['vendors.index']
            ],
            'vendors.edit' => [
                'label' => 'Vendors Edit',
                'dependencies' => ['vendors.index']
            ],
            'vendors.edit.post' => [
                'label' => 'Vendors Update',
                'dependencies' => ['vendors.index']
            ],
            'items.index' => 'Items View',
            'items.add' => [
                'label' => 'Items Create',
                'dependencies' => ['items.index']
            ],
            'items.edit' => [
                'label' => 'Items Edit',
                'dependencies' => ['items.index']
            ],
            'items.edit.post' => [
                'label' => 'Items Update',
                'dependencies' => ['items.index']
            ],
        ],

        'Vouchers' => [
            'vouchers.index' => 'Vouchers View',
            'vouchers.add' => [
                'label' => 'Vouchers Create',
                'dependencies' => ['vouchers.index']
            ],
            'vouchers.edit' => [
                'label' => 'Vouchers Edit',
                'dependencies' => ['vouchers.index']
            ],
            'vouchers.edit.post' => [
                'label' => 'Vouchers Update',
                'dependencies' => ['vouchers.index']
            ],
            'vouchers.detail' => [
                'label' => 'Vouchers Detail',
                'dependencies' => ['vouchers.index']
            ],
        ],

        'Routines' => [
            'routines.index' => 'Routines View',
            'routines.add' => [
                'label' => 'Routines Create',
                'dependencies' => ['routines.index']
            ],
            'routines.edit' => [
                'label' => 'Routines Edit',
                'dependencies' => ['routines.index']
            ],
            'routines.edit.post' => [
                'label' => 'Routines Update',
                'dependencies' => ['routines.index']
            ],
            'routines.delete' => [
                'label' => 'Routines Delete',
                'dependencies' => ['routines.index']
            ],
        ],

        'Attendance' => [
            'student-attendance.index' => 'Student Attendance View',
            'student-attendance.make' => 'Student Attendance Get',
            'student-attendance.make.post' => 'Student Attendance Make',
            'student-attendance.report' => 'Student Attendance Report',
            'teacher-attendance.index' => 'Teacher Attendance View',
            'teacher-attendance.make' => 'Teacher Attendance Get',
            'teacher-attendance.make.post' => 'Teacher Attendance Make',
            'teacher-attendance.report' => 'Teacher Attendance Report',
            'employee-attendance.index' => 'Employee Attendance View',
            'employee-attendance.make' => 'Employee Attendance Get',
            'employee-attendance.make.post' => 'Employee Attendance Make',
            'employee-attendance.report' => 'Employee Attendance Report',
        ],

        'Attendance Leave' => [
            'attendance-leave.index' => 'Leave View',
            'attendance-leave.get.data' => 'get Data',
            'attendance-leave.make' => [
                'label' => 'Leave Make',
                'dependencies' => ['attendance-leave.index']
            ],
            'attendance-leave.edit' => 'Leave Edit',
            'attendance-leave.update' => [
                'label' => 'Leave Update',
                'dependencies' => ['attendance-leave.index']
            ],
            'attendance-leave.delete' => [
                'label' => 'Leave Delete',
                'dependencies' => ['attendance-leave.index']
            ],
        ],

        'Student Migrations' => [
            'student-migrations.index' => 'Migrations View',
            'student-migrations.create' => 'Migrations Create',
        ],

        'Exams & Results' => [
            'exam.index' => 'Exams View',
            'exam.add' => [
                'label' => 'Exams Create',
                'dependencies' => ['exam.index']
            ],
            'exam.edit' => [
                'label' => 'Exams Edit',
                'dependencies' => ['exam.index']
            ],
            'exam.edit.post' => [
                'label' => 'Exams Update',
                'dependencies' => ['exam.index']
            ],
            'manage-result.index' => 'Results View',
            'manage-result.make' => [
                'label' => 'Results Make',
                'dependencies' => ['manage-result.index']
            ],
            'manage-result.attributes' => 'Results Attributes',
            'manage-result.maketranscript' => [
                'label' => 'Make Transcript',
                'dependencies' => ['manage-result.index']
            ],
            'manage-result.maketranscript.create' => 'Create Transcript',
            'manage-result.result' => 'View Result',
        ],

        'Quizzes' => [
            'quizzes.index' => 'Quizzes View',
            'quizzes.get.data' => 'Get Data',
            'quizzes.create' => [
                'label' => 'Quiz Create',
                'dependencies' => ['quizzes.index']
            ],
            'quizzes.edit' => 'Quiz Edit',
            'quizzes.update' => [
                'label' => 'Quiz Update',
                'dependencies' => ['quizzes.index']
            ],
            'quizzes.delete' => [
                'label' => 'Quiz Delete',
                'dependencies' => ['quizzes.index']
            ],
            'quizresult.index' => 'Quiz Result View',
            'quizresult.create' => 'Quiz Result Create',
        ],

        'Library' => [
            'library.index' => 'Library View',
            'library.add' => [
                'label' => 'Library Create',
                'dependencies' => ['library.index']
            ],
            'library.edit' => [
                'label' => 'Library Edit',
                'dependencies' => ['library.index']
            ],
            'library.edit.post' => [
                'label' => 'Library Update',
                'dependencies' => ['library.index']
            ],
        ],

        'Notice Board' => [
            'noticeboard.index' => 'Notice View',
            'noticeboard.create' => [
                'label' => 'Notice Create',
                'dependencies' => ['noticeboard.index']
            ],
            'noticeboard.delete' => [
                'label' => 'Notice Delete',
                'dependencies' => ['noticeboard.index']
            ],
        ],

        'Fee Management' => [
            'fee.index' => 'Fee View',
            'fee.create' => 'Get Student',
            'fee.create.store' => [
                'label' => 'Fee Create',
                'dependencies' => ['fee.index']
            ],
            'fee.get.invoice.collect' => 'Get Invoice Collect',
            'fee.collect.store' => [
                'label' => 'Store Invoice Collect',
                'dependencies' => ['fee.index']
            ],
            'fee.edit.invoice' => 'Edit Invoice',
            'fee.edit.invoice.post' => [
                'label' => 'Update Invoice',
                'dependencies' => ['fee.index']
            ],
            'fee.get.student.fee' => 'Get Student Fee',
            'fee.update' => 'Student Fee Update',
            'fee.chalan.print' => 'Chalan Print',
            'fee.group.chalan.print' => 'Group Chalan Print',
            'fee.invoice.print' => 'Invoice Print',
            'fee.bulk.print.invoice' => 'Bulk Print Invoice',
            'fee.bulk.create.invoice' => 'Bulk Create Invoice',
            'fee.bulk.create.group.invoice' => 'Bulk Group Invoice',
        ],

        'Expenses' => [
            'expense.index' => 'Expenses View',
            'expense.add' => [
                'label' => 'Expenses Create',
                'dependencies' => ['expense.index']
            ],
            'expense.edit' => [
                'label' => 'Expenses Edit',
                'dependencies' => ['expense.index']
            ],
            'expense.edit.post' => [
                'label' => 'Expenses Update',
                'dependencies' => ['expense.index']
            ],
            'expense.summary' => 'Expenses Summary',
        ],

        'SMS Notifications' => [
            'smsnotifications.index' => 'SMS View',
            'smsnotifications.sendsms' => 'Send SMS',
            'smsnotifications.sendbulksms' => 'Send Bulk SMS',
            'smsnotifications.history' => 'SMS History',
        ],

        'Message Notifications' => [
            'msg-notifications.index' => 'View',
            'msg-notifications.get.data' => 'Get Data',
            'msg-notifications.send' => 'Message Send',
            'msg-notifications.msg.log' => 'View Message Logs',
        ],

        'Reports' => [
            'seatsreport' => 'Seats Report',
            'fee-collection-reports.index' => 'Fee Collection View',
            'fee-collection-reports.fee.receipts.statment' => 'Fee Receipts Statement',
            'fee-collection-reports.daily.fee.collection' => 'Daily Fee Collection',
            'fee-collection-reports.free.ship.students' => 'Freeship Students',
            'fee-collection-reports.unpaid.fee.statment' => 'Unpaid Fee Statement',
            'fee-collection-reports.yearly.collection.statment' => 'Yearly Collection Statement',
            'exam-reports.index' => 'Exam Reports View',
            'exam-reports.tabulation.sheet' => 'Tabulation Sheet',
            'exam-reports.award.list' => 'Award List',
            'exam-reports.average.result' => 'Average Result',
            'exam-reports.result.transcript' => 'Result Transcript',
        ],

        'System Settings' => [
            'system-setting.index' => 'System Settings View',
            'system-setting.update' => 'System Settings Update',
            'system-setting.module.permissions.update' => [
                'label' => 'Update Module Permissions',
                'dependencies' => ['system-setting.index', 'system-setting.module.permissions']
            ],
            'system-setting.print.invoice.history' => 'Print Invoice History',
            'system-setting.history' => 'System History',
            'system-setting.notification.settings' => 'Notification Settings',
            'fee-scenario.index' => 'Fee Scenario View',
            'fee-scenario.update.scenario' => 'Fee Scenario Update',
            'exam-grades.index' => 'Exam Grades View',
            'exam-grades.update' => 'Exam Grades Update',
        ],
    ],

    'default_permissions' => [
        //dashboad
        'dashboard.top_content',
        'dashboard.timeline',
        'dashboard.monthly_attendance',
        'dashboard.fee_Collection',
        'dashboard.monthly_expenses',

        //update Users password
        'users.update.update_password',

        //class
        'students.class_edit',
    ]

];
