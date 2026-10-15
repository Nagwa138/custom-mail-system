<?php

return [
    'api_key' => 'YOUR_STATIC_API_KEY',

    // Active provider: 'smtp' | 'brevo' | 'sendgrid'
    // Only the selected provider's block needs real credentials.
    'provider' => 'smtp',

    'smtp' => [
        'host'       => 'mail.yourdomain.com',
        'port'       => 465,          // 465 = SSL, 587 = TLS/STARTTLS
        'encryption' => 'ssl',        // 'ssl' or 'tls'
        'username'   => 'you@yourdomain.com',
        'password'   => 'YOUR_EMAIL_PASSWORD',
        'from_email' => 'you@yourdomain.com',
        'from_name'  => 'Your App Name',
    ],

    // Brevo transactional email HTTP API — https://app.brevo.com/settings/keys/api
    'brevo' => [
        'api_key'    => 'YOUR_BREVO_API_KEY',
        'from_email' => 'you@yourdomain.com',
        'from_name'  => 'Your App Name',
    ],

    // SendGrid Mail Send HTTP API — https://app.sendgrid.com/settings/api_keys
    'sendgrid' => [
        'api_key'    => 'YOUR_SENDGRID_API_KEY',
        'from_email' => 'you@yourdomain.com',
        'from_name'  => 'Your App Name',
    ],
];
