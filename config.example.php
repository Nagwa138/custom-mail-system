<?php

return [
    'api_key' => 'YOUR_STATIC_API_KEY',

    'smtp' => [
        'host'       => 'mail.yourdomain.com',
        'port'       => 465,          // 465 = SSL, 587 = TLS/STARTTLS
        'encryption' => 'ssl',        // 'ssl' or 'tls'
        'username'   => 'you@yourdomain.com',
        'password'   => 'YOUR_EMAIL_PASSWORD',
        'from_email' => 'you@yourdomain.com',
        'from_name'  => 'Your App Name',
    ],
];
