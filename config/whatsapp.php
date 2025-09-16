<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for WhatsApp integration using go-whatsapp-web-multidevice
    | service at gowa.simaru.my.id
    |
    */

    // Service URL for WhatsApp API
    'service_url' => env('WHATSAPP_SERVICE_URL', 'https://gowa.simaru.my.id'),

    // Basic Authentication credentials for WhatsApp service
    'username' => env('WHATSAPP_USERNAME', 'admin'),
    'password' => env('WHATSAPP_PASSWORD', 'admin'),

    // Admin phone number to receive notifications (format: 628123456789)
    'admin_phone' => env('WHATSAPP_ADMIN_PHONE', '628123456789'),

    // Enable/disable WhatsApp notifications
    'enabled' => env('WHATSAPP_ENABLED', true),

    // HTTP timeout for API requests (seconds)
    'timeout' => env('WHATSAPP_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Message Templates
    |--------------------------------------------------------------------------
    |
    | Default message templates for different notification types
    |
    */

    'templates' => [
        'admin_notification' => [
            'title' => '🔔 *NOTIFIKASI TAMU BARU*',
            'header' => '📋 *PTSP Kemenag Nganjuk*',
            'footer' => '_Pesan otomatis dari sistem buku tamu_'
        ],
        'guest_confirmation' => [
            'title' => '✅ *KONFIRMASI CHECK-IN*',
            'greeting' => 'Halo *{nama}*,',
            'footer' => '_Pesan otomatis dari sistem buku tamu_'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | WhatsApp API endpoints configuration
    |
    */

    'endpoints' => [
        'login' => '/app/login',
        'logout' => '/app/logout',
        'devices' => '/app/devices',
        'send_message' => '/send/message',
    ],

    /*
    |--------------------------------------------------------------------------
    | Phone Number Format
    |--------------------------------------------------------------------------
    |
    | Phone number formatting configuration
    |
    */

    'phone_format' => [
        'country_code' => '62', // Indonesia
        'suffix' => '@s.whatsapp.net', // WhatsApp format
    ],
];
