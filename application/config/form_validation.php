<?php 

$config = [
    'login' => [
        'user' => [
            'field' => 'user', 
            'label' => 'ID Number',
            'rules' => 'required'
        ],
        'pwd' => [
            'field' => 'pwd', 
            'label' => 'Password',
            'rules' => 'required|min_length[8]'
        ],
    ],

    't' => [
        'user' => [
            'field' => 'token', 
            'label' => 'Token',
            'rules' => 'required'
        ], 
    ],
    
    'id' => [
        'id' => [
            'field' => 'id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
    ],

    'course_add' => [
        'department_id' => [
            'field' => 'department_id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
        'course_code' => [
            'field' => 'course_code', 
            'label' => 'Course Code',
            'rules' => 'required'
        ],  
        'course_name' => [
            'field' => 'course_name', 
            'label' => 'Course Name',
            'rules' => 'required'
        ], 
    ],
    
    'course_update' => [
        'course_id' => [
            'field' => 'department_id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
        'department_id' => [
            'field' => 'department_id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
        'course_name' => [
            'field' => 'course_name', 
            'label' => 'Course Name',
            'rules' => 'required'
        ], 
    ],

    'department_add' => [
        'department_name' => [
            'field' => 'department_name', 
            'label' => 'Department Name',
            'rules' => 'required'
        ],
    ],
    
    'subject_add' => [
        'course_id' => [
            'field' => 'course_id', 
            'label' => 'Course ID',
            'rules' => 'required|numeric'
        ],
        'subject_code' => [
            'field' => 'subject_code', 
            'label' => 'Course Code',
            'rules' => 'required'
        ],
        'subject_name' => [
            'field' => 'subject_name', 
            'label' => 'Subject Name',
            'rules' => 'required'
        ],
    ],

    'subject_update' => [
        'subject_id' => [
            'field' => 'subject_id', 
            'label' => 'Subject ID',
            'rules' => 'required|numeric'
        ],
        'course_id' => [
            'field' => 'course_id', 
            'label' => 'Course ID',
            'rules' => 'required|numeric'
        ],
        'subject_code' => [
            'field' => 'subject_code', 
            'label' => 'Course Code',
            'rules' => 'required'
        ],
        'subject_name' => [
            'field' => 'subject_name', 
            'label' => 'Subject Name',
            'rules' => 'required'
        ],
    ],

    'reports_add' => [
        'student_id' => [
            'field' => 'student_id', 
            'label' => 'Student ID',
            'rules' => 'required|numeric'
        ],
        'narration_incident' => [
            'field' => 'narration_incident', 
            'label' => 'Narration Incident',
            'rules' => 'required'
        ],
        'action_taken' => [
            'field' => 'action_taken', 
            'label' => 'Action Taken',
            'rules' => 'required'
        ],
        'remark' => [
            'field' => 'remark', 
            'label' => 'status',
            'rules' => 'required'
        ],
    ],

    'admin_add' => [
        'username' => [
            'field' => 'username', 
            'label' => 'Username',
            'rules' => 'required|is_unique[admin.username]'
        ],
        'password' => [
            'field' => 'password', 
            'label' => 'Password',
            'rules' => 'required'
        ],
    ],

    'faculty_add' => [
        'faculty_name' => [
            'field' => 'faculty_name', 
            'label' => 'Faculty Name',
            'rules' => 'required'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
        'type' => [
            'field' => 'type', 
            'label' => 'Type',
            'rules' => 'required|numeric'
        ],
        'id_number' => [
            'field' => 'id_number', 
            'label' => 'ID Number',
            'rules' => 'required'
        ],
        'employment_status' => [
            'field' => 'employment_status', 
            'label' => 'Employment Status',
            'rules' => 'required|numeric'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
    ],

    'faculty_update' => [
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ],
        'faculty_name' => [
            'field' => 'faculty_name', 
            'label' => 'Faculty Name',
            'rules' => 'required'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
        'type' => [
            'field' => 'type', 
            'label' => 'Type',
            'rules' => 'required|numeric'
        ],
        'id_number' => [
            'field' => 'id_number', 
            'label' => 'ID Number',
            'rules' => 'required'
        ],
        'employment_status' => [
            'field' => 'employment_status', 
            'label' => 'Employment Status',
            'rules' => 'required|numeric'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
    ],

    'degree_add' => [
        'degree_title' => [
            'field' => 'degree_title[]', 
            'label' => 'Degree Title',
            'rules' => 'required'
        ],
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'degree_delete' => [
        'facult_id' => [
            'field' => 'faculty_id',
            'label' => 'ID',
            'rules' => 'required|numeric'
        ],
        'degree_id' => [
            'field' => 'id[]', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
    ],

    'degree_update' => [
        'degree_title' => [
            'field' => 'faculty_name[]', 
            'label' => 'Faculty Name',
            'rules' => 'required'
        ],
        'degree_id' => [
            'field' => 'degree_id[]', 
            'label' => 'Degree ID',
            'rules' => 'required|numeric'
        ],
        'faculty_id' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ]
    ],
    
    'taught_add' => [
        'course_id' => [
            'field' => 'faculty_name[]', 
            'label' => 'Faculty Name',
            'rules' => 'required|numeric'
        ],
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'taught_delete' => [
        'facult_id' => [
            'field' => 'faculty_id',
            'label' => 'ID',
            'rules' => 'required|numeric'
        ],
        'taught_id' => [
            'field' => 'id[]', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
    ],

    'taught_update' => [
        'course_id' => [
            'field' => 'course_id[]', 
            'label' => 'Course ID',
            'rules' => 'required|numberic'
        ],
        'taught_id' => [
            'field' => 'taught_id[]', 
            'label' => 'Degree ID',
            'rules' => 'required|numeric'
        ],
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],


    'qualifications_add' => [
        'q_title' => [
            'field' => 'q_title[]', 
            'label' => 'Qualifications Title',
            'rules' => 'required'
        ],
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'qualifications_delete' => [
        'facult_id' => [
            'field' => 'faculty_id',
            'label' => 'FacultyID',
            'rules' => 'required|numeric'
        ],
        'q_id' => [
            'field' => 'id[]', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
    ],
 
    'qualifications_update' => [
        'q_title' => [
            'field' => 'q_title[]', 
            'label' => 'Qualifications Title',
            'rules' => 'required'
        ],
        'q_id' => [
            'field' => 'q_id[]', 
            'label' => 'Qualifications ID',
            'rules' => 'required|numeric'
        ],
        'faculty_id' => [
            'field' => 'faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

];