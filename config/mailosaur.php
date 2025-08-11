<?php

// config for ChrisReedIO/Mailosaur
return [
    'api_key' => env('MAILOSAUR_API_KEY'),
    'server_id' => env('MAILOSAUR_SERVER_ID'),
    'domain' => env('MAILOSAUR_EMAIL_DOMAIN', env('MAILOSAUR_SERVER_ID').'.mailosaur.net'),
];
