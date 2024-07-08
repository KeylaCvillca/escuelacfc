<?php

return [
    'createPost' => [
        'type' => 2,
        'description' => 'Crear un post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Actualizar un post',
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'createPost',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'updatePost',
            'author',
        ],
    ],
];
