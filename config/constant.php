<?php

return [
    'cacheTime' => 30,
    'limit' => [
        'company' => 6,
        'job' => 20,
        'relatedJob' => 6
    ],
    'moreCompany' => 15,
    'roleEmployer' => [
    	'5ac85f51b9068c2384007d9e',
    	'5ac85f51b9068c2384007d9f'
    ],
    'roles' => [
        'candidate' => '5ac85f51b9068c2384007d9c',
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
        10, 11, 12
    ],

    'statusJob' => [
        1, 10, 11, 12
    ],

    /**
     * Table define
     */
    'STATUS_DEFAULT' => 0,
    'USERS' => 'users',
    'USER' => 'user',

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
    // 'CREATE_USER_'
];
