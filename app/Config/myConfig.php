<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyConfig extends BaseConfig
{
    public $students = [
        [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'student_id' => 'CS2101',
            'major' => 'Computer Science',
            'gpa' => 3.5,
            'enrollment_year' => 2021,
        ],
        [
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'student_id' => 'IS2102',
            'major' => 'Information Systems',
            'gpa' => 3.8,
            'enrollment_year' => 2020,
        ],
    ];
}