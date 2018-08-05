<?php

$config = [
    'install/step1' => [
        [
            'field' => 'hostname',
            'rules' => 'trim|required',
            'label' => ''
        ],
        [
            'field' => 'database',
            'rules' => 'trim|required',
            'label' => 'database name'
        ],
        [
            'field' => 'username',
            'rules' => 'trim|required',
            'label' => ''
        ],
        [
            'field' => 'password',
            'rules' => 'trim|required',
            'label' => ''
        ],
    ],
    'install/step2' => [
        [
            'field' => 'website_title',
            'rules' => 'trim|required',
            'label' => 'website title'
        ],
        [
            'field' => 'default_title',
            'rules' => 'trim|required',
            'label' => 'frontend default title'
        ],
        [
            'field' => 'frontend_theme',
            'rules' => 'trim|required',
            'label' => 'frontend theme name'
        ],
    ],
    'install/step3' => [
        [
            'field' => 'username',
            'rules' => 'trim|required',
            'label' => 'username'
        ],
        [
            'field' => 'password',
            'rules' => 'trim|required',
            'label' => 'password'
        ],        
    ]
];