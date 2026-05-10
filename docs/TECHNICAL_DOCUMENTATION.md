# BiLTA CMS — Technical Documentation

> **Bible and Literature Translation Association**
> Plot 324, Flat No.2 Bauhinia Avenue, Off Great-East Rd - Chelstone | www.bilta.org | P.O.BOX G27 LUSAKA, ZAMBIA

**Version:** 2.0
**Last Updated:** May 2026
**Stack:** Laravel 8.75 • Livewire 2.11 • Bootstrap 5.1 • SB Admin 2 • MySQL

---

## Table of Contents

1. [System Overview](#1-system-overview)
2. [Architecture](#2-architecture)
3. [Technology Stack](#3-technology-stack)
4. [Authentication & Authorisation](#4-authentication--authorisation)
5. [Role-Based Access Control (RBAC)](#5-role-based-access-control-rbac)
6. [Database Schema](#6-database-schema)
7. [Module Reference](#7-module-reference)
8. [Leave Management System](#8-leave-management-system)
9. [Email Notification System](#9-email-notification-system)
10. [Analytics & Tracking](#10-analytics--tracking)
11. [Security Features](#11-security-features)
12. [API & Routes](#12-api--routes)
13. [Deployment Guide](#13-deployment-guide)

---

## 1. System Overview

The BiLTA CMS is a web application serving two primary functions:

1. **Public Website** — A content-managed website showcasing BiLTA's mission, translation projects, news, prayer points, audio Bible recordings, gallery, videos, FAQs, and team profiles.

2. **Admin Portal** — A comprehensive back-office system for:
   - Content management (news, projects, media, pages)
   - Human Resource management (departments, employee profiles)
   - Leave management with configurable multi-stage approval workflows
   - Role-based access control with granular permissions
   - Visitor analytics and click tracking
   - Email communications (contact forms, newsletter, sponsorship)

### High-Level Architecture Diagram

```
┌──────────────────────────────────────────────────────────┐
│                    PUBLIC WEBSITE                         │
│  Home | About | Services | News | Projects | Gallery     │
│  Videos | Audio Bible | Prayer Points | FAQs | Contact   │
└──────────────────┬───────────────────────────────────────┘
                   │ Authentication (Laravel Auth)
┌──────────────────▼───────────────────────────────────────┐
│                    ADMIN PORTAL                           │
│  ┌─────────────┐ ┌─────────────┐ ┌────────────────────┐  │
│  │  Content     │ │  HR / Leave │ │  System Settings   │  │
│  │  Management  │ │  Management │ │  Roles/Permissions │  │
│  └─────────────┘ └─────────────┘ └────────────────────┘  │
│  ┌─────────────┐ ┌─────────────┐ ┌────────────────────┐  │
│  │  Analytics   │ │  Email/Comms│ │  Departments       │  │
│  └─────────────┘ └─────────────┘ └────────────────────┘  │
└──────────────────────────────────────────────────────────┘
```

---

## 2. Architecture

### Design Patterns

| Pattern | Implementation |
|---------|---------------|
| **MVC + Component** | Laravel MVC base with Livewire full-page components replacing traditional controllers/views |
| **RBAC** | Custom trait-based (`HasPermissionsTrait`) with Gate integration via `PermissionServiceProvider` |
| **Repository/Service** | `SpamFilterService` for email spam scoring |
| **Observer** | Click tracking via `TrackClicks` middleware |
| **Pipeline** | Multi-stage approval workflows |

### Directory Structure

```
app/
├── Console/Kernel.php              # Scheduled tasks
├── Exceptions/Handler.php          # Error handling
├── Http/
│   ├── Kernel.php                  # Middleware stack
│   ├── Controllers/                # Traditional controllers (Contact, Newsletter, Sponsor)
│   ├── Livewire/
│   │   ├── Admin/                  # Admin panel components (30+)
│   │   ├── Site/                   # Public page components (18+)
│   │   └── System/                 # System management (Users, Roles, Permissions, Statuses)
│   └── Middleware/
│       ├── RoleMiddleware.php      # Route-level role check
│       ├── PermissionMiddleware.php # Route-level permission check
│       └── TrackClicks.php         # Visitor analytics tracking
├── Mail/                           # 6 Mailable classes
├── Models/
│   ├── Bilta/                      # Domain models (30+)
│   └── System/                     # Role, Permission, Status
├── Permissions/
│   └── HasPermissionsTrait.php     # User role/permission trait
├── Providers/
│   └── PermissionServiceProvider.php # Registers Gates for all permissions
└── Services/
    └── SpamFilterService.php       # Contact form spam detection
```

### Request Lifecycle

1. Request enters via `public/index.php`
2. Passes through global middleware (CORS, CSRF, etc.)
3. `TrackClicks` middleware logs visitor analytics (non-admin GET requests)
4. Route middleware checks authentication (`auth`) and authorisation (`role:admin` or `permission:X`)
5. Livewire component handles the request (full-page or AJAX)
6. Response rendered using Blade layouts (`layouts.master` for public, `layouts.admin.master` for admin)

---

## 3. Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Language** | PHP | ^7.3 \| ^8.0 |
| **Framework** | Laravel | 8.75 |
| **Frontend Engine** | Livewire | 2.11 |
| **CSS Framework** | Bootstrap | 5.1.3 |
| **Admin Template** | SB Admin 2 | Custom-themed |
| **Database** | MySQL | 5.7+ / 8.0 |
| **Media Library** | Spatie Media Library | 10.x |
| **Geolocation** | Stevebauman Location | - |
| **Browser Detection** | Jenssegers Agent | - |
| **Email** | SwiftMailer (via Laravel Mail) | - |
| **Package Manager** | Composer (PHP), NPM (JS) | - |
| **Asset Bundler** | Laravel Mix (Webpack) | - |
| **Server** | Apache/Nginx via Laragon | - |

---

## 4. Authentication & Authorisation

### Authentication
- Standard Laravel `Auth` scaffolding with email/password login
- Session-based authentication using `web` guard
- Login tracking: `logins` count and `last_login` timestamp on the User model

### Authorisation Layers

| Layer | Mechanism | Scope |
|-------|-----------|-------|
| **Route Middleware** | `role:admin` on system routes | Entire route group |
| **Route Middleware** | `permission:manage-about-us` on individual routes | Single route |
| **Blade Directives** | `@can`, `@canany`, `@role` | UI visibility |
| **Gate Checks** | `auth()->user()->can('permission-slug')` | Runtime logic |
| **Component Methods** | `canActOnApplication()` | Business logic |

### How Permissions Work

```
PermissionServiceProvider::boot()
  → Loads ALL Permission records from DB
  → For each: Gate::define('slug', fn(User) => $user->hasPermission('slug'))

HasPermissionsTrait::hasPermission()
  → Checks users_permissions pivot (direct assignment)
  → Checks users_roles → roles_permissions (inherited via role)
  → Returns true if permission found either way
```

---

## 5. Role-Based Access Control (RBAC)

### Roles

| Role | Slug | Access Level |
|------|------|-------------|
| **Administrator** | `admin` | Full access to all features (`*`) |
| **Content Manager** | `content-manager` | All content + leave + departments (30 permissions) |
| **Editor** | `editor` | Content editing only (16 permissions) |
| **Viewer** | `viewer` | Read-only dashboard + analytics (5 permissions) |

### Permission Categories (34 total)

| Category | Permissions |
|----------|------------|
| **Dashboard** | `view-dashboard` |
| **Company** | `manage-home-intro`, `manage-about-us`, `manage-values`, `manage-services`, `manage-contact-us`, `manage-chairman-message`, `manage-sponsors`, `view-emails`, `view-front-requests`, `manage-team` |
| **Content** | `manage-faqs`, `manage-prayer-points`, `manage-news`, `manage-testimonies`, `manage-testimonials`, `manage-gallery`, `manage-videos`, `manage-audio`, `manage-projects`, `manage-categories`, `view-analytics` |
| **Leave** | `manage-leave-types`, `manage-leave-applications`, `apply-leave`, `manage-leave-balances`, `manage-approval-workflows` |
| **HR** | `manage-departments` |
| **System** | `manage-roles`, `manage-permissions`, `manage-statuses`, `manage-users`, `clear-cache` |

### Database Schema for RBAC

```
users ──M:M── users_roles ──M:M── roles
  │                                  │
  └──M:M── users_permissions         └──M:M── roles_permissions ──M:M── permissions
```

---

## 6. Database Schema

### Core Tables (46 migrations)

#### Authentication & Users
| Table | Purpose |
|-------|---------|
| `users` | Employee/user accounts with full HR profile fields |
| `password_resets` | Password reset tokens |
| `personal_access_tokens` | API token management (Sanctum) |

#### RBAC
| Table | Purpose |
|-------|---------|
| `roles` | Role definitions (admin, content-manager, editor, viewer) |
| `permissions` | Permission definitions (34 permissions) |
| `roles_permissions` | Role ↔ Permission pivot |
| `users_roles` | User ↔ Role pivot |
| `users_permissions` | User ↔ Permission pivot (direct assignment) |
| `statuses` | System status values (Active, Inactive, Pending, Approved) |

#### Content Management
| Table | Purpose |
|-------|---------|
| `about_us` | About us page content |
| `contact_us` | Contact information and social links |
| `our_values` | Organisational values |
| `our_services` | Services offered |
| `f_a_qs` | Frequently asked questions |
| `weekly_prayer_points` | Weekly prayer point entries |
| `our_teams` | Leadership team member profiles |
| `home_intros` | Homepage hero/intro sections |
| `chairman_messages` | Chairman's message with photo |
| `testimonies` | Full testimonies |
| `testimonials` | Short testimonial quotes |
| `item_categories` | Shared categories for news/projects/gallery/video |
| `news_item` | News articles |
| `projects` | Translation project entries |
| `gallery_item` | Photo gallery items |
| `video_item` | Video entries (YouTube embeds) |
| `audio_files` | Audio Bible recordings |
| `audio_comments` | Comments on audio files |
| `sponsors` | Sponsor logos and info |
| `media` | Spatie MediaLibrary polymorphic media storage |

#### HR & Leave Management
| Table | Purpose |
|-------|---------|
| `departments` | Organisational departments (10 seeded) |
| `leave_types` | Leave type configuration (7 types seeded) |
| `leave_applications` | Employee leave requests with full form data |
| `leave_balances` | Per-user per-type per-year leave entitlements |
| `approval_workflows` | Configurable multi-stage workflow definitions |
| `approval_workflow_stages` | Ordered stages within a workflow, each assigned to a role |
| `approval_history` | Audit trail of every approval/rejection action |

#### Communications
| Table | Purpose |
|-------|---------|
| `contact_messages` | Contact form submissions (with spam scoring) |
| `newsletter_subscribers` | Newsletter email subscriptions |
| `sponsor_inquiries` | Sponsorship inquiry submissions |

#### Analytics
| Table | Purpose |
|-------|---------|
| `clicks` | Detailed visitor click tracking (URL, browser, device, geolocation) |
| `cookie_consents` | GDPR cookie consent records |

#### System
| Table | Purpose |
|-------|---------|
| `failed_jobs` | Queue failed job records |

---

## 7. Module Reference

### 7.1 Content Management Modules

Each content module follows the same pattern:
- **Livewire Component** — Full CRUD with create/edit modal, validation, pagination
- **Spatie MediaLibrary** — Image/file uploads with thumbnail generation
- **Status management** — Active/Inactive toggle
- **Soft deletes** — Recoverable deletion
- **Permission guard** — Route-level `permission:manage-X` middleware

| Module | Component | Model | Features |
|--------|-----------|-------|----------|
| About Us | `ShowAboutUs` | `AboutUs` | Mission, vision, objectives, descriptions |
| Services | `ShowServices` | `OurServices` | Title + description list |
| Values | `ShowValues` | `OurValues` | Title + description list |
| Contact Info | `ShowContactUsDetails` | `ContactUs` | Phone, email, address, social links, Google Maps |
| Home Intro | `ShowHomeIntro` | `HomeIntro` | Hero sections with images |
| Chairman Message | `ShowChairmansMessage` | `ChairmanMessage` | Message with photo |
| Team | `ShowLeadershipTeam` | `OurTeam` | Member profiles with photos, social links |
| FAQs | `ShowFaqs` | `FAQs` | Question/answer pairs |
| Prayer Points | `ShowPrayerPoints` | `WeeklyPrayerPoints` | Dated entries with scriptures |
| News | `ShowNewsItem` | `News` | Articles with images, categories |
| Testimonies | `ShowTestimonies` | `Testimonies` | Full testimonies |
| Testimonials | `ShowTestimonialsPage` | `Testimonial` | Short quotes |
| Gallery | `ShowItemGallery` | `Gallery` | Photo uploads with categories |
| Videos | `ShowItemVidoes` | `Videos` | YouTube links with categories |
| Audio | `ShowItemAudio` | `AudioFile` | Audio file uploads/links |
| Projects | `ShowTranslationProjects` | `Projects` | Translation project tracking with images |
| Categories | `ShowItemCategory` | `ItemCategory` | Shared category management |
| Sponsors | `ShowOurSponsors` | `Sponsor` | Sponsor logos and details |

### 7.2 HR & Leave Module

See [Section 8](#8-leave-management-system) for detailed documentation.

### 7.3 System Administration

| Module | Component | Purpose |
|--------|-----------|---------|
| Users | `UsersIndex` / `UsersShow` | User CRUD with 3-section form (Basic Info, Employment Details, Emergency Contact), role assignment |
| Roles | `RolesIndex` / `RolesShow` | Role CRUD with permission assignment |
| Permissions | `PermissionsIndex` | Permission CRUD |
| Statuses | `StatusIndex` | Status value management |
| Departments | `ShowDepartments` | Department CRUD with head assignment |

---

## 8. Leave Management System

### 8.1 Overview

The leave management system provides a complete digital leave application workflow replacing BiLTA's physical paper form. It includes:

- Self-service leave application for all employees
- Configurable multi-stage approval workflows
- Automatic leave balance tracking
- Email notifications at every stage
- Full audit trail of all actions

### 8.2 Leave Types (7 default)

| Type | Default Days | Requires Document | Paid | Carry Over |
|------|-------------|-------------------|------|------------|
| Annual Leave | 24 | No | Yes | Yes (max 10) |
| Sick Leave | 26 | Yes | Yes | No |
| Maternity Leave | 90 | Yes | Yes | No |
| Paternity Leave | 5 | Yes | Yes | No |
| Compassionate Leave | 5 | No | Yes | No |
| Hospitalisation Leave | 30 | Yes | Yes | No |
| Others | 0 | No | No | No |

### 8.3 Application Form

The digital form mirrors BiLTA's physical leave form with 7 sections:

1. **Employee Information** — Auto-filled from user profile (name, position, department, phone, NRC, MAN number, email, supervisor)
2. **Leave Dates & Entitlement** — Start date, end date (auto-calculates working days), resume date (auto-calculated, skips weekends), balance summary
3. **Leave Type** — Radio selection matching physical form, "Others" shows free-text field
4. **Reason/Purpose** — Free text (min 10 chars)
5. **Acting Arrangement** — Staff dropdown (auto-fills phone), position dropdown (TA or D/TA)
6. **Supporting Documents** — File upload (PDF, JPG, PNG, DOC — max 5MB)
7. **Declaration** — Auto-signed with applicant name and date

### 8.4 Approval Workflow

```
┌──────────┐     ┌──────────┐     ┌──────────┐     ┌──────────┐
│ Employee │────▶│ Stage 1  │────▶│ Stage 2  │────▶│ Stage N  │
│ Submits  │     │ Review   │     │ Approval │     │ Sign-off │
└──────────┘     └────┬─────┘     └────┬─────┘     └────┬─────┘
                      │                │                 │
                 ┌────▼────┐      ┌────▼────┐      ┌────▼────┐
                 │Approved │      │Approved │      │Approved │
                 │   or    │      │   or    │      │→ FINAL  │
                 │Rejected │      │Rejected │      │APPROVED │
                 └─────────┘      └─────────┘      └─────────┘
```

**Key Rules:**
- Each stage is assigned to a **role** — any user with that role can act
- **Rejection at any stage** terminates the workflow immediately
- **Approval advances** to the next stage (by `stage_order`)
- **Final stage approval** marks the application as fully approved and **deducts leave balance**
- Employees can **cancel** their own pending applications
- Approvers must provide a **reason/comment** before approving or rejecting

### 8.5 Leave Balance

- Balances are tracked per user, per leave type, per year
- Formula: `Remaining = (Total Days + Carried Over) − Used Days`
- Balance is only deducted on **full approval** (not at submission)
- Admins can allocate balances individually or bulk-allocate defaults for all active users
- Carry-over from previous year is configurable per leave type

### 8.6 Email Notifications

| Event | Recipient | Mailable |
|-------|-----------|----------|
| Application submitted | Applicant | `LeaveSubmissionConfirmationMail` |
| Application submitted | First-stage approvers | `LeaveApprovalRequestMail` |
| Stage approved (not final) | Applicant | `LeaveStatusUpdateMail` |
| Stage approved (not final) | Next-stage approvers | `LeaveApprovalRequestMail` |
| Final stage approved | Applicant | `LeaveStatusUpdateMail` |
| Rejected at any stage | Applicant | `LeaveStatusUpdateMail` |

---

## 9. Email Notification System

### Mailable Classes

| Class | Trigger | Template |
|-------|---------|----------|
| `ContactMessageMail` | Contact form submission | `emails.contact_message` |
| `NewsletterSubscriptionMail` | Newsletter signup | `emails.newsletter_subscription` |
| `SponsorInquiryMail` | Sponsorship inquiry | `emails.sponsor_inquiry` |
| `LeaveSubmissionConfirmationMail` | Leave application submitted | `emails.leave-submission-confirmation` |
| `LeaveApprovalRequestMail` | New application needs approval | `emails.leave-approval-request` |
| `LeaveStatusUpdateMail` | Application approved/rejected | `emails.leave-status-update` |

### Spam Protection
Contact form submissions pass through `SpamFilterService` which scores messages on:
- Spam keyword matches (+1 each)
- Short message length (+1 if < 10 words)
- URL presence (+1)
- Blacklisted domain (+2)
- Blacklisted email (+2)
- **Threshold:** Score ≥ 3 → flagged as spam

---

## 10. Analytics & Tracking

### Click Tracking (`TrackClicks` middleware)

Every non-admin, non-bot GET request is logged with:
- URL, page name, HTTP method, referrer
- IP address, user agent
- Device type (desktop/mobile/tablet)
- Platform (Windows/Mac/Linux/iOS/Android)
- Browser (Chrome/Firefox/Safari/Edge)
- Geolocation (country, city, region, timezone, lat/lng)
- Session ID, authenticated user ID

### Analytics Dashboard (`ClickAnalytics` component)

- Total clicks, unique visitors, pages viewed
- Clicks by country, browser, platform, city
- Top visited URLs
- Daily trend charts
- Referrer analysis
- Date range filtering

### Cookie Consent
GDPR-compliant cookie consent tracking via `CookieConsent` model.

---

## 11. Security Features

| Feature | Implementation |
|---------|---------------|
| CSRF Protection | Laravel `VerifyCsrfToken` middleware on all POST/PUT/DELETE |
| XSS Prevention | Blade `{{ }}` auto-escapes output |
| SQL Injection | Eloquent ORM parameterised queries |
| Rate Limiting | `throttle:5,1` on contact/newsletter/sponsor forms |
| File Upload Validation | Type + size restrictions (max 5MB, specific MIME types) |
| Spam Filtering | `SpamFilterService` scores + blacklist on contact submissions |
| RBAC | 34 granular permissions, 4 roles, middleware + Gate + Blade guards |
| Password Hashing | bcrypt via Laravel `Hash` facade |
| Soft Deletes | Recoverable deletion on all content models |
| Audit Trail | `ApprovalHistory` logs every workflow action with actor + timestamp |
| Error Handling | Custom error pages (403, 404, 500), no debug info in production |

---

## 12. API & Routes

### Public Routes (no authentication)

| Method | URI | Purpose |
|--------|-----|---------|
| GET | `/` | Homepage |
| GET | `/bilta/site/about` | About page |
| GET | `/bilta/site/services` | Services page |
| GET | `/bilta/site/news/{category}` | News listing |
| GET | `/bilta/site/news/details/{id}/{slug}` | News detail |
| GET | `/bilta/site/projects/{category}` | Projects listing |
| GET | `/bilta/site/projects/details/{id}` | Project detail |
| GET | `/bilta/site/Gallery` | Photo gallery |
| GET | `/bilta/site/videos` | Video gallery |
| GET | `/bilta/site/audio/bible` | Audio Bible listing |
| GET | `/bilta/site/Faqs` | FAQs |
| GET | `/bilta/site/WeeklyPrayerPoint` | Prayer points |
| POST | `/contact` | Contact form (throttled) |
| POST | `/newsletter/subscribe` | Newsletter signup (throttled) |
| POST | `/sponsor/inquiry` | Sponsor inquiry (throttled) |

### Admin Routes (authenticated, permission-guarded)

All under prefix `/bilta/zadmin/home/`:
- `/` — Dashboard
- `/company/*` — Company info management (7 routes)
- `/page/*` — Content page management (6 routes)
- `/item/*` — Media/content item management (8 routes)
- `/departments` — Department management
- `/leave/*` — Leave management (5 routes)
- `/admin/live-analytics/clicks` — Analytics dashboard

### System Routes (admin role only)

All under prefix `/system/`:
- `/statuses` — Status CRUD
- `/permissions` — Permission CRUD
- `/roles` — Role CRUD
- `/roles/{role}` — Role detail + permission assignment
- `/users` — User list
- `/users/{uuid}` — User detail + edit

---

## 13. Deployment Guide

### Requirements
- PHP 7.3+ or 8.0+
- MySQL 5.7+ or 8.0+
- Composer 2.x
- Node.js 14+ / NPM 6+
- Apache or Nginx with mod_rewrite

### Environment Setup

```bash
# Clone repository
git clone <repo-url> && cd BiltaWebsite

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run production

# Environment
cp .env.example .env
php artisan key:generate

# Configure .env with:
# - DB_* (database credentials)
# - MAIL_* (SMTP settings for notifications)
# - APP_ENV=production
# - APP_DEBUG=false

# Database
php artisan migrate --force
php artisan db:seed --force

# Storage
php artisan storage:link

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Seeded Data
- 4 Roles with mapped permissions
- 34 Permissions
- 10 Departments (Human Resources, Finance, Translation, etc.)
- 7 Leave Types with default day allocations
- System statuses (Active, Inactive, Pending, Approved)

### Maintenance Commands
```bash
# Clear all caches
php artisan optimize:clear

# Re-discover Livewire components
php artisan livewire:discover

# Rebuild config/route/view caches
php artisan optimize

# Check for pending migrations
php artisan migrate:status
```

---

*This document is auto-generated for BiLTA CMS v2.0. For questions or updates, contact the development team.*
