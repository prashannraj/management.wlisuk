<?php

return [
    'driver' => 'mailchimp',

    'drivers' => [
        'mailchimp' => [
            'apiKey' => env('MAILCHIMP_APIKEY'),
            'defaultListName' => 'subscribers',
            'lists' => [
                'subscribers' => [
                    'id' => env('MAILCHIMP_LIST_ID'),
                ],
            ],
        ],
    ],
];
