<?php 

$config = [
    'login' => [
        'user' => [
            'field' => 'user', 
            'label' => 'ID Number',
            'rules' => 'required'
        ],
        'password' => [
            'field' => 'pwd', 
            'label' => 'Password',
            'rules' => 'required|min_length[8]'
        ],
    ],
];