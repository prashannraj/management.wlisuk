<?php

return [

    'driver' => env('NEWSLETTER_DRIVER', 'mailchimp'),

    'mailchimp' => [
        'apiKey' => env('MAILCHIMP_APIKEY'),
        'server' => env('MAILCHIMP_SERVER_PREFIX'),
    ],

    'mailchimp_list_id' => env('MAILCHIMP_LIST_ID'),

];
