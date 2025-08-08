<?php

return [

    'paths' => ['api/', 'otp/', 'webhook/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000'], // atau domain chatbot kamu

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
