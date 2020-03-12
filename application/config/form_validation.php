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
        'course_type[]' => [
            'field' => 'course_type[]', 
            'label' => 'Course Type',
            'rules' => 'required|numeric'
        ], 
        'course_abbv[]' => [
            'field' => 'course_abbv[]', 
            'label' => 'Course Code',
            'rules' => 'required'
        ],  
        'course_name[]' => [
            'field' => 'course_name[]', 
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
        'department_id[]' => [
            'field' => 'department_id[]', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ], 
        'course_name[]' => [
            'field' => 'course_name[]', 
            'label' => 'Course Name',
            'rules' => 'required'
        ], 
    ],

    'department_add' => [
        'dept_name' => [
            'field' => 'dept_name', 
            'label' => 'Department Name',
            'rules' => 'required|is_unique[departments.dept_name]'
        ], 
        'dept_abbv' => [
            'field' => 'dept_abbv', 
            'label' => 'Department Code',
            'rules' => 'required|is_unique[departments.dept_abbv]|alpha'
        ],
    ],

    'department_update' => [
        'dept_id' => [
            'field' => 'dept_id', 
            'label' => 'Department ID',
            'rules' => 'required|numeric'
        ], 
        'dept_name' => [
            'field' => 'dept_name', 
            'label' => 'Department Name',
            'rules' => 'required|is_unique[departments.dept_name]'
        ], 
        'dept_abbv' => [
            'field' => 'dept_abbv', 
            'label' => 'Department Code',
            'rules' => 'required|is_unique[departments.dept_abbv]|alpha'
        ],
    ],
    
    'subject_add' => [
        'course_id' => [
            'field' => 'course_id', 
            'label' => 'Course ID',
            'rules' => 'required|numeric'
        ],
        'subject_code[]' => [
            'field' => 'subject_code[]', 
            'label' => 'Course Code',
            'rules' => 'required'
        ],
        'subject_name[]' => [
            'field' => 'subject_name[]', 
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
        'rs_student_id[]' => [
            'field' => 'rs_student_id[]', 
            'label' => 'Violators ID',
            'rules' => 'required|numeric'
        ],
        'case_name' => [
            'field' => 'case_name', 
            'label' => 'Case Name',
            'rules' => 'required'
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

    'reports_update' => [
        'student_id' => [
            'field' => 'student_id', 
            'label' => 'Student ID',
            'rules' => 'required|numeric'
        ],
        'report_id' => [
            'field' => 'report_id', 
            'label' => 'Report ID',
            'rules' => 'required|numeric'
        ],
        'case_name' => [
            'field' => 'case_name', 
            'label' => 'Case Name',
            'rules' => 'required'
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
            'label' => 'Remarks',
            'rules' => 'required'
        ],
    ],

    'reports_student_add' => [
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
    ],

    'reports_student_update' => [
        'student_id' => [
            'field' => 'student_id', 
            'label' => 'Student ID',
            'rules' => 'required|numeric'
        ],
        'report_id' => [
            'field' => 'report_id', 
            'label' => 'Report ID',
            'rules' => 'required|numeric'
        ],
        'narration_incident' => [
            'field' => 'narration_incident', 
            'label' => 'Narration Incident',
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
        'faculty_type' => [
            'field' => 'faculty_type', 
            'label' => 'Faculty Type',
            'rules' => 'required|numeric'
        ],
        'faculty_sur_name' => [
            'field' => 'faculty_sur_name', 
            'label' => 'Sur Name',
            'rules' => 'required|alpha_numeric_spaces'
        ],
        'faculty_first_name' => [
            'field' => 'faculty_first_name', 
            'label' => 'First Name',
            'rules' => 'required|alpha_numeric_spaces'
        ],
        'faculty_middle_name' => [
            'field' => 'faculty_middle_name', 
            'label' => 'Middle Name',
            'rules' => 'alpha_numeric_spaces'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
        'gender' => [
            'field' => 'gender', 
            'label' => 'Gender',
            'rules' => 'required|numeric'
        ],
        'contact_no' => [
            'field' => 'contact_no', 
            'label' => 'Contact Number',
            'rules' => 'required|numeric'
        ],
        'email' => [
            'field' => 'email', 
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        'id_number' => [
            'field' => 'id_number', 
            'label' => 'ID Number',
            'rules' => 'required|min_length[6]'
        ],
        'employment_status' => [
            'field' => 'employment_status', 
            'label' => 'Employment Status',
            'rules' => 'required|numeric'
        ],
    ],

    'faculty_update' => [
        'id' => [
            'field' => 'id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ],
        'faculty_type' => [
            'field' => 'faculty_type', 
            'label' => 'Faculty Type',
            'rules' => 'required|numeric'
        ],
        'faculty_sur_name' => [
            'field' => 'faculty_sur_name', 
            'label' => 'Sur Name',
            'rules' => 'required|alpha_numeric_spaces'
        ],
        'faculty_first_name' => [
            'field' => 'faculty_first_name', 
            'label' => 'First Name',
            'rules' => 'required|alpha_numeric_spaces'
        ],
        'faculty_middle_name' => [
            'field' => 'faculty_middle_name', 
            'label' => 'Middle Name',
            'rules' => 'alpha_numeric_spaces'
        ],
        'department' => [
            'field' => 'department', 
            'label' => 'Department',
            'rules' => 'required|numeric'
        ],
        'gender' => [
            'field' => 'gender', 
            'label' => 'Gender',
            'rules' => 'required|numeric'
        ],
        'contact_no' => [
            'field' => 'contact_no', 
            'label' => 'Contact Number',
            'rules' => 'required|numeric'
        ],
        'email' => [
            'field' => 'email', 
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        'id_number' => [
            'field' => 'id_number', 
            'label' => 'ID Number',
            'rules' => 'required|min_length[6]'
        ],
        'employment_status' => [
            'field' => 'employment_status', 
            'label' => 'Employment Status',
            'rules' => 'required|numeric'
        ],
    ],


    'degree_add' => [
        'degree_title' => [
            'field' => 'degree_title[]', 
            'label' => 'Degree Title',
            'rules' => 'required'
        ],
        'degree_faculty_id' => [
            'field' => 'degree_faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'degree_delete' => [
        'degree_id' => [
            'field' => 'degree_id[]', 
            'label' => 'Degree ID',
            'rules' => 'required|numeric'
        ]
    ],

    'degree_update' => [
        'degree_title' => [
            'field' => 'degree_title[]', 
            'label' => 'Degree Title',
            'rules' => 'required'
        ],
        'degree_id' => [
            'field' => 'degree_id[]', 
            'label' => 'Degree ID',
            'rules' => 'required|numeric'
        ]
    ],
    
    'taught_add' => [
        'sf_subject_id' => [
            'field' => 'sf_subject_id[]', 
            'label' => 'Subject ID',
            'rules' => 'required|numeric'
        ],
        'sf_faculty_id' => [
            'field' => 'sf_faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'taught_delete' => [
        'sf_id' => [
            'field' => 'sf_id[]', 
            'label' => 'Subject Taught ID',
            'rules' => 'required|numeric'
        ], 
    ],

    'taught_update' => [
        'sf_subject_id' => [
            'field' => 'sf_subject_id[]', 
            'label' => 'Subject ID',
            'rules' => 'required|numberic'
        ],
        'sf_id' => [
            'field' => 'sf_id[]', 
            'label' => 'Subject Taught ID',
            'rules' => 'required|numeric'
        ]
    ],


    'qualifications_add' => [
        'q_title' => [
            'field' => 'q_title[]', 
            'label' => 'Qualifications Title',
            'rules' => 'required'
        ],
        'q_faculty_id' => [
            'field' => 'q_faculty_id', 
            'label' => 'Faculty ID',
            'rules' => 'required|numeric'
        ]
    ],

    'qualifications_delete' => [
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
        ]
    ],

    'ss_add' => [
        'q_title' => [
            'field' => 'ss_student_id', 
            'label' => 'Student ID',
            'rules' => 'required|numeric'
        ],
        'q_id' => [
            'field' => 'ss_subject_id', 
            'label' => 'Subjects ID',
            'rules' => 'required|numeric'
        ],
    ],

    'profile_img' => [
        'id' => [
            'field' => 'id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ],
    ],

    'department_img' => [
        'id' => [
            'field' => 'id', 
            'label' => 'Department ID',
            'rules' => 'required|numeric'
        ],
    ],

    'students_add' => [
        'id_number' => [
            'field' => 'id_number[]', 
            'label' => 'Student ID Number',
            'rules' => 'required'
        ],
        'sur_name' => [
            'field' => 'sur_name[]', 
            'label' => 'Sur Name',
            'rules' => 'required'
        ],
        'first_name' => [
            'field' => 'first_name[]', 
            'label' => 'First Name',
            'rules' => 'required'
        ],
        'middle_name' => [
            'field' => 'middle_name[]', 
            'label' => 'Middle Name',
            'rules' => 'required'
        ],
        'course' => [
            'field' => 'course[]', 
            'label' => 'Course',
            'rules' => 'required|numeric'
        ],
        'year_level' => [
            'field' => 'year_level[]', 
            'label' => 'Year Level',
            'rules' => 'required|numeric'
        ],
        'academic_year' => [
            'field' => 'academic_year[]', 
            'label' => 'Academic Year',
            'rules' => 'required|numeric'
        ],
        'birthdate' => [
            'field' => 'birthdate[]', 
            'label' => 'Birthdate',
            'rules' => 'required'
        ],
        'birth_place' => [
            'field' => 'birth_place[]', 
            'label' => 'Birthplace',
            'rules' => 'required'
        ],
        'gender' => [
            'field' => 'gender[]', 
            'label' => 'Gender',
            'rules' => 'required|numeric'
        ],
        'citizenship' => [
            'field' => 'citizenship[]', 
            'label' => 'Citizenship',
            'rules' => 'required|numeric'
        ],
        'civil_status' => [
            'field' => 'civil_status[]', 
            'label' => 'Civil Status',
            'rules' => 'required|numeric'
        ],
        'religion' => [
            'field' => 'religion[]', 
            'label' => 'Religion',
            'rules' => 'required'
        ],
        'email' => [
            'field' => 'email[]', 
            'label' => 'Email',
            'rules' => 'required'
        ],
        'contact_no' => [
            'field' => 'contact_no[]', 
            'label' => 'Contact Number',
            'rules' => 'required|numeric'
        ],
        'p_address' => [
            'field' => 'p_address[]', 
            'label' => 'Permanent Address',
            'rules' => 'required'
        ],
        't_address' => [
            'field' => 't_address[]', 
            'label' => 'Temporary Address',
            'rules' => 'required'
        ],
        'mother' => [
            'field' => 'mother[]', 
            'label' => 'Mother\'s Name',
            'rules' => 'required'
        ],
        'mother_no' => [
            'field' => 'mother_no[]', 
            'label' => 'Mother Contact Number',
            'rules' => 'required|numeric'
        ],
        'father' => [
            'field' => 'father[]', 
            'label' => 'Father\'s Name',
            'rules' => 'required'
        ],
        'father_no' => [
            'field' => 'father_no[]', 
            'label' => 'Father Contact Number',
            'rules' => 'required|numeric'
        ],
        'guardian' => [
            'field' => 'guardian[]', 
            'label' => 'Guardian\'s Name',
            'rules' => 'required'
        ],
        'guardian_no' => [
            'field' => 'guardian_no[]', 
            'label' => 'Guardian Contact Number',
            'rules' => 'required|numeric'
        ],
    ],
    'students_add' => [
        'id' => [
            'field' => 'id', 
            'label' => 'ID',
            'rules' => 'required|numeric'
        ],
        'id_number' => [
            'field' => 'id_number', 
            'label' => 'Student ID Number',
            'rules' => 'required'
        ],
        'sur_name' => [
            'field' => 'sur_name', 
            'label' => 'Sur Name',
            'rules' => 'required'
        ],
        'first_name' => [
            'field' => 'first_name', 
            'label' => 'First Name',
            'rules' => 'required'
        ],
        'middle_name' => [
            'field' => 'middle_name', 
            'label' => 'Middle Name',
            'rules' => 'required'
        ],
        'course' => [
            'field' => 'course', 
            'label' => 'Course',
            'rules' => 'required|numeric'
        ],
        'year_level' => [
            'field' => 'year_level', 
            'label' => 'Year Level',
            'rules' => 'required|numeric'
        ],
        'academic_year' => [
            'field' => 'academic_year', 
            'label' => 'Academic Year',
            'rules' => 'required|numeric'
        ],
        'birthdate' => [
            'field' => 'birthdate', 
            'label' => 'Birthdate',
            'rules' => 'required'
        ],
        'birth_place' => [
            'field' => 'birth_place', 
            'label' => 'Birthplace',
            'rules' => 'required'
        ],
        'gender' => [
            'field' => 'gender', 
            'label' => 'Gender',
            'rules' => 'required|numeric'
        ],
        'citizenship' => [
            'field' => 'citizenship', 
            'label' => 'Citizenship',
            'rules' => 'required|numeric'
        ],
        'civil_status' => [
            'field' => 'civil_status', 
            'label' => 'Civil Status',
            'rules' => 'required|numeric'
        ],
        'religion' => [
            'field' => 'religion', 
            'label' => 'Religion',
            'rules' => 'required'
        ],
        'email' => [
            'field' => 'email', 
            'label' => 'Email',
            'rules' => 'required'
        ],
        'contact_no' => [
            'field' => 'contact_no', 
            'label' => 'Contact Number',
            'rules' => 'required|numeric'
        ],
        'p_address' => [
            'field' => 'p_address', 
            'label' => 'Permanent Address',
            'rules' => 'required'
        ],
        't_address' => [
            'field' => 't_address', 
            'label' => 'Temporary Address',
            'rules' => 'required'
        ],
        'mother' => [
            'field' => 'mother', 
            'label' => 'Mother\'s Name',
            'rules' => 'required'
        ],
        'mother_no' => [
            'field' => 'mother_no', 
            'label' => 'Mother Contact Number',
            'rules' => 'required|numeric'
        ],
        'father' => [
            'field' => 'father', 
            'label' => 'Father\'s Name',
            'rules' => 'required'
        ],
        'father_no' => [
            'field' => 'father_no', 
            'label' => 'Father Contact Number',
            'rules' => 'required|numeric'
        ],
        'guardian' => [
            'field' => 'guardian', 
            'label' => 'Guardian\'s Name',
            'rules' => 'required'
        ],
        'guardian_no' => [
            'field' => 'guardian_no', 
            'label' => 'Guardian Contact Number',
            'rules' => 'required|numeric'
        ],
    ],
];