<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Support & Ticketing
    |--------------------------------------------------------------------------
    */

    // Ticket reference format: PREFIX-YEAR-0001
    'reference_prefix' => env('SUPPORT_REFERENCE_PREFIX', 'TKT'),

    // Currency shown on billing rates and reports (ISO 4217)
    'currency' => env('SUPPORT_CURRENCY', 'USD'),

    // Default hourly rate created by SupportSettingsSeeder (editable in Support > Settings)
    'default_hourly_rate' => env('SUPPORT_DEFAULT_HOURLY_RATE', 25),

    // Work logs are recorded in these increments (0.25 = quarter hour)
    'hours_step' => 0.25,

    // Optional shared support inbox that also receives "new ticket" alerts
    'notify_inbox' => env('SUPPORT_NOTIFY_EMAIL'),

    // Set false to disable all support emails (e.g. during data imports)
    'emails_enabled' => env('SUPPORT_EMAILS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Attachments
    |--------------------------------------------------------------------------
    | Files are kept on a PRIVATE disk and only served through an authorised
    | route. SVG/HTML/script/executable types are intentionally not allowed.
    */
    'attachments' => [
        'disk' => 'local',
        'directory' => 'support-tickets',
        'max_kb' => 10240,
        'max_files' => 5,
        'mimes' => ['png', 'jpg', 'jpeg', 'webp', 'pdf', 'txt', 'log', 'csv', 'doc', 'docx', 'xls', 'xlsx'],
        'inline_mimes' => ['image/png', 'image/jpeg', 'image/webp'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Work log types
    |--------------------------------------------------------------------------
    */
    'work_types' => [
        'analysis' => 'Analysis / Investigation',
        'development' => 'Development',
        'testing' => 'Testing',
        'deployment' => 'Deployment',
        'support' => 'Support / Communication',
        'other' => 'Other',
    ],
];
