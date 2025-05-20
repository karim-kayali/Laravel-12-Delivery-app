<?php

return [

    'default' => env('BROADCAST_DRIVER2', 'null'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY2'),
            'secret' => env('PUSHER_APP_SECRET2'),
            'app_id' => env('PUSHER_APP_ID2'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER2'),
                'useTLS' => true,
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

    'channels' => [],

];
