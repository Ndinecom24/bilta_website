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
            'name' => 'Super Administrator',
            'slug' => 'super-admin',
            'description' => 'Unrestricted master access across all system configurations, security, workflows, and modules.',
        ],
        [
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Full administrative access across system features and operations.',
        ],
        [
            'name' => 'System Administrator',
            'slug' => 'system-admin',
            'description' => 'Assistant to Super Admins — operational system maintenance, user accounts, and status management.',
        ],
        [
            'name' => 'Content Manager',
            'slug' => 'content-manager',
            'description' => 'Manage all public website content, media, news, publications, and gallery.',
        ],
        [
            'name' => 'HR Manager',
            'slug' => 'hr-manager',
            'description' => 'Oversees human resources, staff directory, department structures, leave balances, and HR approvals.',
        ],
        [
            'name' => 'HR Officer',
            'slug' => 'hr-officer',
            'description' => 'Operational HR staff handling employee leave requests, balances, and department assignments.',
        ],
        [
            'name' => 'Finance',
            'slug' => 'finance',
            'description' => 'Financial operations, expenditure tracking, financial approvals, and payroll/allowance oversight.',
        ],
        [
            'name' => 'Employee',
            'slug' => 'employee',
            'description' => 'Baseline staff role — apply for leave, view internal announcements, access shared documents, and training resources.',
        ],
        [
            'name' => 'Supervisor',
            'slug' => 'supervisor',
            'description' => 'First-level line manager approving leave applications and overseeing direct subordinates.',
        ],
        [
            'name' => 'Company Secretariat',
            'slug' => 'company-secretariat',
            'description' => 'Corporate governance and secretariat authority for institutional leave review and sign-off.',
        ],
        [
            'name' => 'Senior Executive',
            'slug' => 'senior-executive',
            'description' => 'Executive leadership with company-wide visibility over all staff applications and institutional workflows.',
        ],
        [
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Create and edit website content without administrative system access.',
        ],
        [
            'name' => 'Viewer',
            'slug' => 'viewer',
            'description' => 'Read-only access to dashboard statistics and public enquiries.',
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
            'name' => 'Approver',
            'slug' => 'approver',
            'description' => 'Staff member with designated review and approval authority.',
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
        [
            'name' => 'Support Developer',
            'slug' => 'support-developer',
            'description' => 'Technical support team member who works System Support tickets, records work and resolves issues.',
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
        ['name' => 'Manage Partners', 'slug' => 'manage-sponsors'],
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

        // --- System & User Administration ---
        ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
        ['name' => 'Manage Permissions', 'slug' => 'manage-permissions'],
        ['name' => 'Manage Statuses', 'slug' => 'manage-statuses'],
        ['name' => 'Manage Users', 'slug' => 'manage-users'],
        ['name' => 'Delete Users', 'slug' => 'delete-users'],
        ['name' => 'Manage User Roles', 'slug' => 'manage-user-roles'],
        ['name' => 'Clear Cache', 'slug' => 'clear-cache'],

        // --- HR & Department Management ---
        ['name' => 'Manage Departments', 'slug' => 'manage-departments'],
        ['name' => 'Create Departments', 'slug' => 'create-departments'],
        ['name' => 'Edit Departments', 'slug' => 'edit-departments'],
        ['name' => 'Delete Departments', 'slug' => 'delete-departments'],
        ['name' => 'Manage Positions', 'slug' => 'manage-positions'],
        ['name' => 'Create Positions', 'slug' => 'create-positions'],
        ['name' => 'Edit Positions', 'slug' => 'edit-positions'],
        ['name' => 'Delete Positions', 'slug' => 'delete-positions'],
        ['name' => 'Manage HR Profiles', 'slug' => 'manage-hr-profiles'],
        ['name' => 'Manage Branches', 'slug' => 'manage-branches'],
        ['name' => 'Create Branches', 'slug' => 'create-branches'],
        ['name' => 'Edit Branches', 'slug' => 'edit-branches'],
        ['name' => 'Delete Branches', 'slug' => 'delete-branches'],

        // --- Leave Management & Workflow ---
        ['name' => 'Apply for Leave', 'slug' => 'apply-leave'],
        ['name' => 'Manage Leave Applications', 'slug' => 'manage-leave-applications'],
        ['name' => 'View All Leave Applications', 'slug' => 'view-all-leave-applications'],
        ['name' => 'Approve or Reject Leave Applications', 'slug' => 'approve-reject-leave'],
        ['name' => 'Delete Leave Applications', 'slug' => 'delete-leave-applications'],
        ['name' => 'Override Leave Status', 'slug' => 'override-leave-status'],
        ['name' => 'Manage Leave Types', 'slug' => 'manage-leave-types'],
        ['name' => 'Manage Leave Balances', 'slug' => 'manage-leave-balances'],
        ['name' => 'Manage Approval Workflows', 'slug' => 'manage-approval-workflows'],

        // --- Internal Communications & Documents ---
        ['name' => 'View Announcements', 'slug' => 'view-announcements'],
        ['name' => 'Manage Announcements', 'slug' => 'manage-announcements'],
        ['name' => 'Delete Announcements', 'slug' => 'delete-announcements'],
        ['name' => 'View Documents', 'slug' => 'view-documents'],
        ['name' => 'Manage Documents', 'slug' => 'manage-documents'],
        ['name' => 'Delete Documents', 'slug' => 'delete-documents'],
        ['name' => 'View Training Resources', 'slug' => 'view-training'],

        // --- Finance & Budgets ---
        ['name' => 'Manage Finance', 'slug' => 'manage-finance'],
        ['name' => 'View Financials', 'slug' => 'view-financials'],
        ['name' => 'Approve Financials', 'slug' => 'approve-financials'],

        // --- System Support & Ticketing ---
        ['name' => 'Submit Support Tickets', 'slug' => 'submit-support-tickets'],
        ['name' => 'View All Support Tickets', 'slug' => 'view-all-support-tickets'],
        ['name' => 'Work Support Tickets (Developer)', 'slug' => 'work-support-tickets'],
        ['name' => 'Assign Support Tickets', 'slug' => 'assign-support-tickets'],
        ['name' => 'View Support Dashboard', 'slug' => 'view-support-dashboard'],
        ['name' => 'View Support Reports', 'slug' => 'view-support-reports'],
        ['name' => 'Manage Support Settings', 'slug' => 'manage-support-settings'],
        ['name' => 'Manage Support Billing', 'slug' => 'manage-support-billing'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role-Permission Assignments
    |--------------------------------------------------------------------------
    | Map which permissions each role receives by default.
    */
    'role_permissions' => [

        // Super Admin has master unrestricted access across every permission
        'super-admin' => '*',
        'admin' => '*',

        // System Admin: Assistant to Super Admin (operational user and system administration)
        'system-admin' => [
            'view-dashboard',
            'manage-users',
            'manage-user-roles',
            'manage-statuses',
            'view-analytics',
            'clear-cache',
            'manage-departments',
            'manage-positions',
            'view-announcements',
            'manage-announcements',
            'view-documents',
            'manage-documents',
            'apply-leave',
            'view-training',
            'submit-support-tickets',
        ],

        // Content Manager: Public website, media, communications, publication
        'content-manager' => [
            'view-dashboard',
            'submit-support-tickets',
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
            'view-announcements',
            'manage-announcements',
            'view-documents',
            'manage-documents',
            'apply-leave',
            'view-training',
        ],

        // HR Manager: Full human resources management, departments, leave configuration and approvals
        'hr-manager' => [
            'view-dashboard',
            'submit-support-tickets',
            'manage-users',
            'manage-hr-profiles',
            'manage-departments',
            'create-departments',
            'edit-departments',
            'delete-departments',
            'manage-positions',
            'create-positions',
            'edit-positions',
            'delete-positions',
            'manage-branches',
            'create-branches',
            'edit-branches',
            'delete-branches',
            'apply-leave',
            'manage-leave-applications',
            'view-all-leave-applications',
            'approve-reject-leave',
            'delete-leave-applications',
            'manage-leave-types',
            'manage-leave-balances',
            'manage-approval-workflows',
            'view-announcements',
            'manage-announcements',
            'view-documents',
            'manage-documents',
            'view-training',
            'view-analytics',
        ],

        // HR Officer: HR operations, employee leaves, leave balances, department records
        'hr-officer' => [
            'view-dashboard',
            'submit-support-tickets',
            'manage-users',
            'manage-hr-profiles',
            'manage-departments',
            'manage-positions',
            'manage-branches',
            'apply-leave',
            'manage-leave-applications',
            'view-all-leave-applications',
            'approve-reject-leave',
            'manage-leave-types',
            'manage-leave-balances',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Finance: Financial operations, financial reports, allowances and approvals
        'finance' => [
            'view-dashboard',
            'submit-support-tickets',
            'manage-finance',
            'view-financials',
            'approve-financials',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Employee: Baseline role granted to EVERY staff member
        'employee' => [
            'view-dashboard',
            'submit-support-tickets',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Supervisor: Line manager approving direct subordinates
        'supervisor' => [
            'view-dashboard',
            'submit-support-tickets',
            'apply-leave',
            'approve-reject-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Company Secretariat: Corporate governance, institutional sign-off on leave & policy
        'company-secretariat' => [
            'view-dashboard',
            'submit-support-tickets',
            'apply-leave',
            'approve-reject-leave',
            'view-all-leave-applications',
            'view-announcements',
            'manage-announcements',
            'view-documents',
            'manage-documents',
            'view-training',
        ],

        // Senior Executive: Executive visibility across all employee applications & company operations
        'senior-executive' => [
            'view-dashboard',
            'submit-support-tickets',
            'apply-leave',
            'view-all-leave-applications',
            'approve-reject-leave',
            'view-financials',
            'view-announcements',
            'view-documents',
            'view-training',
            'view-analytics',
        ],

        // Editor: Content creation and editing
        'editor' => [
            'view-dashboard',
            'submit-support-tickets',
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
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Viewer: Basic dashboard and enquiry read-only access
        'viewer' => [
            'view-dashboard',
            'submit-support-tickets',
            'view-emails',
            'view-front-requests',
            'view-analytics',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Workflow / Legacy Roles (retained for backward compatibility)
        'leave-applicant' => [
            'view-dashboard',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        'leave-approver' => [
            'view-dashboard',
            'apply-leave',
            'manage-leave-applications',
            'approve-reject-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        'approver' => [
            'view-dashboard',
            'apply-leave',
            'manage-leave-applications',
            'approve-reject-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        'leave-officer' => [
            'view-dashboard',
            'manage-leave-types',
            'manage-leave-applications',
            'approve-reject-leave',
            'apply-leave',
            'manage-leave-balances',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        'leave-workflow-manager' => [
            'view-dashboard',
            'manage-approval-workflows',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        'leave-manager' => [
            'view-dashboard',
            'manage-leave-types',
            'manage-leave-applications',
            'view-all-leave-applications',
            'approve-reject-leave',
            'apply-leave',
            'manage-leave-balances',
            'manage-approval-workflows',
            'view-announcements',
            'view-documents',
            'view-training',
        ],

        // Support developers work tickets; admins/super-admins already receive everything via '*'
        'support-developer' => [
            'view-dashboard',
            'submit-support-tickets',
            'work-support-tickets',
            'view-support-dashboard',
            'apply-leave',
            'view-announcements',
            'view-documents',
            'view-training',
        ],
    ],

];
