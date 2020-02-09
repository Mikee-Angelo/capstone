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
];