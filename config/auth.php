<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    
        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],
    
        'teacher' => [
            'driver' => 'session',
            'provider' => 'teachers',
        ],
    
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],
    
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],
    
        'teachers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Teacher::class,
        ],
    
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],
    
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'teachers' => [
            'provider' => 'teachers',
            'table' => 'teacher_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

];

