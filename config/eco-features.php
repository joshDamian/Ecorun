<?php

return [
    'connect' => [
        'media' => [
            'video' => [
                'upload' => false,
                'download' => false,
                'enabled' => false
            ],
            'audio' => [
                'upload' => false,
                'download' => false,
                'enabled' => false
            ],
            'music' => [
                'upload' => true,
                'download' => true,
                'enabled' => true,
                'lyrics' => false,
                'associated acts' => false
            ],
            'photo' => [
                'upload' => true,
                'download' => false,
                'enabled' => true
            ]
        ],
    ]
];
