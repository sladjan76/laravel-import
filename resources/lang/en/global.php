<?php

return [

	'user-management' => [
		'title' => 'User Management',
		'created_at' => 'Time',
		'fields' => [
		],
	],

	'permissions' => [
		'title' => 'Permissions',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
		],
	],

	'roles' => [
		'title' => 'Roles',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
			'permission' => 'Permissions',
		],
	],

	'users' => [
		'title' => 'Users',
		'created_at' => 'Time',
		'fields' => [
			'id' => 'Id',
			'name' => 'Name',
			'email' => 'Email',
			'created_at' => 'Registered Date',
			'password' => 'Password',
			'role' => 'Role',
			'remember-token' => 'Remember token',
		],
	],

    'data' => [
        'title' => 'Data Import',
    ],

    'import_form' => [
        'title' => 'Import',
    ],

    'imports' => [
        'title' => 'Import History',
        'fields' => [
            'id' => 'Id',
            'import_type' => 'Import Type',
            'file' => 'File',
            'status' => 'Status',
            'created' => 'Created',
        ],
    ],

    'import_errors' => [
        'title' => 'Import Errors',
        'fields' => [
            'id' => 'Id',
            'import_id' => 'Import ID',
            'row_number' => 'Row #',
            'column_name' => 'Column Name',
            'column_value' => 'Column Value',
            'error_message' => 'Error Message',
            'time' => 'Time',
        ]
    ],

	'app_create' => 'Create',
	'app_save' => 'Save',
	'app_edit' => 'Edit',
	'app_view' => 'View',
	'app_update' => 'Update',
	'app_list' => 'List',
	'app_no_entries_in_table' => 'No entries in table',
	'custom_controller_index' => 'Custom controller index.',
	'app_logout' => 'Logout',
	'app_add_new' => 'Add new',
	'app_are_you_sure' => 'Are you sure?',
	'app_back_to_list' => 'Back to list',
	'app_dashboard' => 'Dashboard',
	'app_delete' => 'Delete',
	'app_general_info' => 'General info',
	'app_location' => 'Location info',
	'app_images' => 'Images',
	'app_files_to_upload' => 'Select files to upload',
    'app_file_to_upload' => 'Select file to upload',
	'app_visibility' => 'Visibility',
	'global_title' => 'Admin Panel',
];
