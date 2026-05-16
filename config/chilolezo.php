<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    | Define all application roles with their slugs and display names.
    */
    'roles' => [
        [
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Full access to all features including system settings and user management.',
        ],
        [
            'name' => 'Content Manager',
            'slug' => 'content-manager',
            'description' => 'Manage all content pages, media, news, projects, and ministry content.',
        ],
        [
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Edit existing content but cannot manage users or system settings.',
        ],
        [
            'name' => 'Viewer',
            'slug' => 'viewer',
            'description' => 'Read-only access to admin dashboard and content.',
        ],
        [
            'name' => 'Leave Applicant',
            'slug' => 'leave-applicant',
            'description' => 'Can submit and track own leave applications.',
        ],
        [
            'name' => 'Leave Approver',
            'slug' => 'leave-approver',
            'description' => 'Can access leave approval queue and approve/reject stages assigned to their role.',
        ],
        [
            'name' => 'Leave Officer',
            'slug' => 'leave-officer',
            'description' => 'Can manage leave applications, balances, and leave types.',
        ],
        [
            'name' => 'Leave Workflow Manager',
            'slug' => 'leave-workflow-manager',
            'description' => 'Can configure and maintain leave approval workflows.',
        ],
        [
            'name' => 'Leave Manager',
            'slug' => 'leave-manager',
            'description' => 'Full leave-management access across applications, types, balances, and workflows.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    | Grouped permissions for all admin features and system management.
    */
    'permissions' => [

        // --- Dashboard ---
        ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],

        // --- Company Information ---
        ['name' => 'Manage Home Intro', 'slug' => 'manage-home-intro'],
        ['name' => 'Manage About Us', 'slug' => 'manage-about-us'],
        ['name' => 'Manage Values', 'slug' => 'manage-values'],
        ['name' => 'Manage Services', 'slug' => 'manage-services'],
        ['name' => 'Manage Contact Us', 'slug' => 'manage-contact-us'],
        ['name' => 'Manage Chairman Message', 'slug' => 'manage-chairman-message'],
        ['name' => 'Manage Sponsors', 'slug' => 'manage-sponsors'],
        ['name' => 'View Emails', 'slug' => 'view-emails'],
        ['name' => 'View Front Requests', 'slug' => 'view-front-requests'],
        ['name' => 'Manage Team', 'slug' => 'manage-team'],

        // --- Content Pages ---
        ['name' => 'Manage FAQs', 'slug' => 'manage-faqs'],
        ['name' => 'Manage Prayer Points', 'slug' => 'manage-prayer-points'],
        ['name' => 'Manage News', 'slug' => 'manage-news'],
        ['name' => 'Manage Newsletters', 'slug' => 'manage-newsletters'],
        ['name' => 'Manage Testimonies', 'slug' => 'manage-testimonies'],
        ['name' => 'Manage Testimonials', 'slug' => 'manage-testimonials'],
        ['name' => 'Manage Gallery', 'slug' => 'manage-gallery'],
        ['name' => 'Manage Videos', 'slug' => 'manage-videos'],
        ['name' => 'Manage Audio', 'slug' => 'manage-audio'],
        ['name' => 'Manage Projects', 'slug' => 'manage-projects'],
        ['name' => 'Manage Categories', 'slug' => 'manage-categories'],
        ['name' => 'View Analytics', 'slug' => 'view-analytics'],

        // --- System ---
        ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
        ['name' => 'Manage Permissions', 'slug' => 'manage-permissions'],
        ['name' => 'Manage Statuses', 'slug' => 'manage-statuses'],
        ['name' => 'Manage Users', 'slug' => 'manage-users'],
        ['name' => 'Clear Cache', 'slug' => 'clear-cache'],

        // --- Leave Management ---
        ['name' => 'Manage Leave Types', 'slug' => 'manage-leave-types'],
        ['name' => 'Manage Leave Applications', 'slug' => 'manage-leave-applications'],
        ['name' => 'Apply for Leave', 'slug' => 'apply-leave'],
        ['name' => 'Manage Leave Balances', 'slug' => 'manage-leave-balances'],
        ['name' => 'Manage Approval Workflows', 'slug' => 'manage-approval-workflows'],

        // --- HR / Organisation ---
        ['name' => 'Manage Departments', 'slug' => 'manage-departments'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role-Permission Assignments
    |--------------------------------------------------------------------------
    | Map which permissions each role receives by default.
    */
    'role_permissions' => [

        'admin' => '*', // All permissions

        'content-manager' => [
            'view-dashboard',
            'manage-home-intro',
            'manage-about-us',
            'manage-values',
            'manage-services',
            'manage-contact-us',
            'manage-chairman-message',
            'manage-sponsors',
            'view-emails',
            'view-front-requests',
            'manage-team',
            'manage-faqs',
            'manage-prayer-points',
            'manage-news',
            'manage-newsletters',
            'manage-testimonies',
            'manage-testimonials',
            'manage-gallery',
            'manage-videos',
            'manage-audio',
            'manage-projects',
            'manage-categories',
            'view-analytics',
            'manage-leave-types',
            'manage-leave-applications',
            'apply-leave',
            'manage-leave-balances',
            'manage-approval-workflows',
            'manage-departments',
        ],

        'editor' => [
            'view-dashboard',
            'manage-home-intro',
            'manage-about-us',
            'manage-values',
            'manage-services',
            'manage-chairman-message',
            'manage-faqs',
            'manage-prayer-points',
            'manage-news',
            'manage-newsletters',
            'manage-testimonies',
            'manage-testimonials',
            'manage-gallery',
            'manage-videos',
            'manage-audio',
            'manage-projects',
            'apply-leave',
        ],

        'viewer' => [
            'view-dashboard',
            'view-emails',
            'view-front-requests',
            'view-analytics',
            'apply-leave',
        ],

        'leave-applicant' => [
            'view-dashboard',
            'apply-leave',
        ],

        'leave-approver' => [
            'view-dashboard',
            'apply-leave',
        ],

        'leave-officer' => [
            'view-dashboard',
            'manage-leave-types',
            'manage-leave-applications',
            'apply-leave',
            'manage-leave-balances',
        ],

        'leave-workflow-manager' => [
            'view-dashboard',
            'manage-approval-workflows',
            'apply-leave',
        ],

        'leave-manager' => [
            'view-dashboard',
            'manage-leave-types',
            'manage-leave-applications',
            'apply-leave',
            'manage-leave-balances',
            'manage-approval-workflows',
        ],
    ],

];
