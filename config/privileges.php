<?php

return [

//	'default'	=> [
		// Dashboard
		1 => ['default'	=>	1],
		// Teachers
		2 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'find'		=>	1,
			'image'		=>	1,
			'profile'	=>	1,
			],
		// Manage Classes
		3 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Manage Sections
		4 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Parents
		5 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'profile'	=>	1,
			],
		// User Settings
		6 => [
			'default'	=>	1,
			'changepwd'	=>	1,
			'changesession'	=>	1,
			'skincfg'	=>	0,
			],
		// Subjects
		7 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Class routine
		8 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'delete'	=>	0,
			],
		// Students
		9 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'image'		=>	1,
			'profile'	=>	1,
			],
		// Students Attendance
		10 => [
			'default'	=>	0,
			'make'		=>	0,
			'report'	=>	0,
			],
		// Teacher Attendance
		11 => [
			'default'	=>	0,
			'make'		=>	0,
			'report'	=>	0,
			],
		// noticeboard
		12 => [
			'default'	=>	0,
			'create'	=>	0,
			'delete'	=>	0,
			],
		// Fee
		13 => [
			'default'	=>	0,
			'create'	=>	0,
			'findstu'	=>	1,
			'invoice'	=>	1,
			],
		// Expense
		14 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'summary'	=>	0,
			],
		// Exam
		15 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Manage Resut
		16 => [
			'default'	=>	0,
			'make'		=>	0,
			'report'	=>	0,
			],
		// Users
		17 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'editpwd'	=>	0,
		],
		// Employee
		23	=>	[
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'find'		=>	1,
			'image'		=>	1,
			'profile'	=>	1,
		],
		// Vendors
		25 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Items
		26 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
		// Vouchers
		27 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			'details'	=>	0,
			],
		// Employee Attendance
		28 => [
			'default'	=>	0,
			'make'		=>	0,
			'report'	=>	0,
			],
		// Library
		29 => [
			'default'	=>	0,
			'add'		=>	0,
			'edit'		=>	0,
			],
//	],


/*
		1 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Dashboard',
				],
			],
		2 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Teacher',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			'image'		=>	[
					'status'	=>	1,
					'label'		=>	'Image',
				],
			'profile'	=>	[
					'status'	=>	1,
					'label'		=>	'Profile',
				],
			],
		3 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Manage Classes',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			],
		4 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Manage Section',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			],
		5 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Parent',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			],
		6 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'User Setting',
				],
			'changepwd'	=>	[
					'status'	=>	1,
					'label'		=>	'Change Pwd'
				],
			],
		7 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Manage Subject',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			],
		8 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Class Routine',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			'delete'	=>	[
					'status'	=>	1,
					'label'		=>	'Delete',
				],
			],
		9 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Student',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			'image'		=>	[
					'status'	=>	1,
					'label'		=>	"Image",
				],
			'profile'	=>	[
					'status'	=>	1,
					'label'		=>	'Profile',
				],
			],
		10 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Student Attendance',
				],
			'make'		=>	[
					'status'	=>	1,
					'label'		=>	'Make',
				],
			'report'	=>	[
					'status'	=>	1,
					'label'		=>	'Report',
				],
			],
		11 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Teacher Attendance',
				],
			'make'		=>	[
					'status'	=>	1,
					'label'		=>	'Make',
				],
			'report'	=>	[
					'status'	=>	1,
					'label'		=>	'Report',
				],
			],
		12 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Notice Board',
				],
			'create'	=>	[
					'status'	=>	1,
					'label'		=>	'Create',
				],
			'delete'	=>	[
					'status'	=>	1,
					'label'		=>	'Delete',
				],
			],
		13 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Fee',
				],
			'create'	=>	[
					'status'	=>	1,
					'label'		=>	'Create',
				],
			'findstu'	=>	[
					'status'	=>	1,
					'label'		=>	'Find Stu',
				],
			'invoice'	=>	[
					'status'	=>	1,
					'label'		=>	'Invoice',
				],
			],
		14 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Expense',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			'summary'	=>	[
					'status'	=>	1,
					'label'		=>	'Summary',
				],
			],
		15 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Exam',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
			],
		16 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Manage Result',
				],
			'make'		=>	[
					'status'	=>	1,
					'label'		=>	'Make',
				],
			'reprot'	=>	[
					'status'	=>	1,
					'label'	=> 'Report'
				],
			],
		17 => [
			'default'	=>	[
					'status'	=>	1,
					'label'		=>	'Users',
				],
			'add'		=>	[
					'status'	=>	1,
					'label'		=>	'Add',
				],
			'edit'		=>	[
					'status'	=>	1,
					'label'		=>	'Edit',
				],
		],
*/


];