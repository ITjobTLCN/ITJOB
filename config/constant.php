<?php

return [
    'cacheTime' => 30,
    'limit' => [
        'company' => 6,
        'job' => 20,
        'relatedJob' => 6
    ],
    'moreCompany' => 6,
    'roleEmployer' => [
    	'5ac85f51b9068c2384007d9e',
    	'5ac85f51b9068c2384007d9f'
    ],
    'roles' => [
        'candidate' => '5ac85f51b9068c2384007d9c',
        'admin' => '5ac85f51b9068c2384007d9d',
    	'employer' => '5ac85f51b9068c2384007d9e',
    	'employee' => '5ac85f51b9068c2384007d9f'
    ],
    'skills' => [
        'android',
        'java',
        'php',
        'ios',
        'net',
        'tester',
        'wordpress'
    ],

    'defaultCity' => 'Hồ Chí Minh',

    'statusAssistant' => [
        10, 11, 12  // 10-pending, 11- approved, 12-denied
    ],
    'statusMaster' => [
        0, 1, 2     // 0-pending, 1- approved, 2-denied
    ],

    'statusJob' => [
        0, 1, 10, 11, 12
    ],

    /**
     * Table define
     */
    'STATUS_DEFAULT' => 0,
    'USERS' => 'users',
    'USER' => 'user',
    'ROLES' => 'roles',
    'ROLE' => 'role',
    'EMPLOYERS' => 'emps',
    'EMPLOYER' => 'emp',
    'SKILLS' => 'skills',
    'SKILL' => 'skill',
    'CITIES' => 'cities',
    'JOBS' => 'jobs',

    /**
     * Type
     */
    'STATUS' => 'status',
    'MESSAGE' => 'message',
    'ERROR' => 'errors',
    /**
     * Message define
     */
    'ERROR_EMAIL_EXIST' => 'This email has already exists',
    'SUCCESS_CREATE_USER' => 'Create user successfully',
    'SUCCESS_EDIT_USER' => 'Edit user successfully',
    'SUCCESS_DELETE_USER' => 'Delete user successfully',
    'FAIL_DELETE_USER' => 'Delete failed',
    'SUCCESS_CREATE_ROLE' => 'Create role successfully',
    'SUCCESS_EDIT_ROLE' => 'Edit role successfully',
    'SUCCESS_DELETE_ROLE' => 'Delete role successfully',
    'FAIL_DELETE_ROLE' => 'Delete role fail because has anyone in this role',
    'SUCCESS_CREATE_EMPLOYER' => 'Create employer successfully',
    'FAIL_CREATE_EMPLOYER' => 'Create employer failed',
    'SUCCESS_EDIT_EMPLOYER' => 'Edit employer successfully',
    'FAIL_EDIT_EMPLOYER' => 'Edit employer failed',

    /**
     * General
     */
    'CREATE_SUCCESS' => 'Create successfully',
    'CREATE_FAIL' => 'Create failed',
    'EDIT_SUCCESS' => 'Edit successfully',
    'EDIT_FAIL' => 'Edit failed',
    'DELETE_SUCCESS' => 'Delete successfully',
    'DELETE_FAIL' => 'Delete failed',


    /**
     * Statistics
     */
    'WEEK' => 'week',
    'YEAR' => 'year',

    /**
     * Activate or deactivate
     */
    'ACTIVE' => 1,
    'INACTIVE' => 2,
    'PENDING' => 0,
];
