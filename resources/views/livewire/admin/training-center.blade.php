<div class="training-center">

    {{-- Custom Styles --}}
    <style>
        .training-center { padding-bottom: 40px; }

        /* Header */
        .training-header {
            background: linear-gradient(135deg, #1e4a3b 0%, #0f2e24 60%, #1a3c30 100%);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        .training-header::before {
            content: '';
            position: absolute; top: -60px; right: -40px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(243,179,61,0.15), transparent 70%);
            pointer-events: none;
        }
        .training-header h1 { font-size: 2rem; font-weight: 800; margin-bottom: .5rem; }
        .training-header p { opacity: .85; margin-bottom: 0; max-width: 600px; }
        .training-header .badge-pill {
            display: inline-block;
            padding: .4rem .8rem; border-radius: 50px;
            background: rgba(243,179,61,.2); color: #f3b33d;
            font-size: .78rem; font-weight: 700;
            margin-bottom: .8rem;
        }

        /* Sidebar nav */
        .training-nav {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,.04);
        }
        .training-nav-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .85rem 1.2rem;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all .2s;
            font-size: .88rem; font-weight: 600;
            color: #475569;
            border-left: 3px solid transparent;
        }
        .training-nav-item:hover {
            background: #f8fafc;
            color: #1e4a3b;
        }
        .training-nav-item.active {
            background: #f0fdf4;
            color: #1e4a3b;
            border-left-color: #1e4a3b;
        }
        .training-nav-item i { width: 22px; text-align: center; }
        .training-nav-item:last-child { border-bottom: none; }

        /* Content */
        .training-content {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(0,0,0,.04);
            min-height: 600px;
        }
        .training-content h2 {
            font-size: 1.5rem; font-weight: 800; color: #1e4a3b;
            border-bottom: 3px solid #f3b33d;
            padding-bottom: .5rem; margin-bottom: 1.5rem;
        }
        .training-content h3 {
            font-size: 1.15rem; font-weight: 700; color: #1e4a3b;
            margin-top: 1.5rem; margin-bottom: .75rem;
        }
        .training-content h4 {
            font-size: 1rem; font-weight: 700; color: #334155;
            margin-top: 1.25rem; margin-bottom: .5rem;
        }
        .training-content p, .training-content li {
            color: #475569; line-height: 1.8; font-size: .92rem;
        }
        .training-content ul, .training-content ol {
            padding-left: 1.5rem; margin-bottom: 1rem;
        }
        .training-content li { margin-bottom: .4rem; }

        /* Step cards */
        .step-card {
            display: flex; gap: 1rem; align-items: flex-start;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.2rem;
            margin-bottom: 1rem;
            transition: all .2s;
        }
        .step-card:hover { border-color: #1e4a3b; background: #f0fdf4; }
        .step-number {
            width: 40px; height: 40px; min-width: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e4a3b, #2d6a4f);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .95rem;
        }
        .step-card h5 { font-weight: 700; color: #1e4a3b; font-size: .95rem; margin-bottom: .3rem; }
        .step-card p { margin-bottom: 0; font-size: .85rem; color: #64748b; }

        /* Tip boxes */
        .tip-box {
            border-radius: 14px; padding: 1rem 1.2rem;
            margin: 1rem 0; font-size: .88rem;
            display: flex; gap: .75rem; align-items: flex-start;
        }
        .tip-box i { margin-top: 2px; font-size: 1.1rem; }
        .tip-info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
        .tip-warning { background: #fef9e8; border: 1px solid #fde68a; color: #92400e; }
        .tip-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .tip-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* Permission table */
        .perm-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .perm-table th { background: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: .78rem; padding: .75rem; border-bottom: 2px solid #e2e8f0; }
        .perm-table td { padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .perm-table tr:hover td { background: #f8fafc; }

        /* Workflow diagram */
        .workflow-visual {
            display: flex; flex-wrap: wrap; align-items: center; gap: .5rem;
            padding: 1.5rem; background: #f8fafc; border-radius: 14px;
            border: 1px solid #e2e8f0; margin: 1rem 0;
        }
        .wf-stage {
            text-align: center; min-width: 100px;
            padding: .6rem .8rem; border-radius: 12px;
            font-size: .82rem; font-weight: 700;
        }
        .wf-submit { background: #dbeafe; color: #1e40af; }
        .wf-pending { background: #fef3c7; color: #92400e; }
        .wf-approved { background: #dcfce7; color: #166534; }
        .wf-arrow { color: #94a3b8; font-size: 1.2rem; }

        @media (max-width: 768px) {
            .training-header { padding: 1.5rem; }
            .training-header h1 { font-size: 1.5rem; }
            .training-content { padding: 1.2rem; }
        }
    </style>

    {{-- Header --}}
    <div class="training-header">
        <div class="badge-pill"><i class="fas fa-graduation-cap mr-1"></i> TRAINING CENTER</div>
        <h1>BiLTA CMS — User Training Guide</h1>
        <p>Learn how to use every feature of the BiLTA admin system. Select a topic from the menu to get started.</p>
    </div>

    <div class="row">
        {{-- Sidebar Navigation --}}
        <div class="col-lg-3 col-md-4 mb-3">
            <div class="training-nav">
                @foreach ($sections as $key => $section)
                    <div class="training-nav-item {{ $activeSection === $key ? 'active' : '' }}"
                         wire:click="setSection('{{ $key }}')" style="cursor:pointer;">
                        <i class="{{ $section['icon'] }}" style="color: {{ $section['color'] }};"></i>
                        {{ $section['title'] }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Content Area --}}
        <div class="col-lg-9 col-md-8">
            <div class="training-content">

                {{-- ============================== GETTING STARTED ============================== --}}
                @if ($activeSection === 'getting-started')
                <h2><i class="fas fa-rocket mr-2" style="color:#2563eb;"></i> Getting Started</h2>

                <p>Welcome to the BiLTA Content Management System! This guide will help you navigate the admin panel and use all available features effectively.</p>

                <h3>Logging In</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Navigate to the Login Page</h5>
                        <p>Open your browser and go to the website. Click "Login" or navigate to <code>/login</code>.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Enter Your Credentials</h5>
                        <p>Enter your email address and the <strong>temporary password</strong> emailed to you when your account was created. Click "Login".</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Change Your Password</h5>
                        <p>On first login (or after an administrator resets your password) you are taken to a <strong>Change Password</strong> page. Choose a new password of <strong>at least 8 characters</strong>, confirm it, and save. You cannot use the rest of the system until this is done.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div>
                        <h5>You're In!</h5>
                        <p>You will be redirected to the dashboard. The sidebar on the left shows all sections you have access to.</p>
                    </div>
                </div>

                <h3>Understanding the Interface</h3>
                <ul>
                    <li><strong>Top Navigation Bar</strong> — Shows your name, a <strong>My Profile</strong> link and <strong>Logout</strong>.</li>
                    <li><strong>Left Sidebar</strong> — Navigation grouped by category. You only see menus you have permission to access.</li>
                    <li><strong>Main Content Area</strong> — Where all forms, tables, and content are displayed.</li>
                    <li><strong>Alerts</strong> — Green messages = success. Red messages = errors. They appear at the top of pages after actions.</li>
                </ul>

                <h3>Sidebar Groups</h3>
                <table class="perm-table">
                    <thead><tr><th>Group</th><th>What You Find There</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Dashboard</strong></td><td>Your home page (all users)</td></tr>
                        <tr><td><strong>Company Information</strong></td><td>Home intro, About Us, Values, Services, Contact Us, Chairman's message, Partners, Contact Emails, Front Requests, Our Team</td></tr>
                        <tr><td><strong>Content Pages</strong></td><td>FAQs, Prayer Points, News, Newsletters, Testimonies, Testimonials, Gallery, Videos, Audio, Projects, Categories, Analytics</td></tr>
                        <tr><td><strong>Departments / Positions</strong></td><td>Organisation structure (HR)</td></tr>
                        <tr><td><strong>Internal</strong></td><td>Announcements, Documents, plus Manage Announcements / Manage Documents for authorised staff</td></tr>
                        <tr><td><strong>Leave Management</strong></td><td>My Leave, All Applications, Leave Types, Leave Balances, Approval Workflows</td></tr>
                        <tr><td><strong>System</strong></td><td>Roles, Permissions, Statuses, User Accounts, User Usage Analytics</td></tr>
                        <tr><td><strong>Help &amp; Training</strong></td><td>This Training Center</td></tr>
                    </tbody>
                </table>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Tip:</strong> If you cannot see a menu item, it means your role does not include that permission. Contact your administrator to request access.</div>
                </div>

                <h3>Your Profile</h3>
                <p>Click your name in the top-right corner and select <strong>"My Profile"</strong> to view your information. The profile page has tabs:</p>
                <ul>
                    <li><strong>Profile</strong> — Basic info (name, email, phone) and your profile photo (images up to 2 MB).</li>
                    <li><strong>Employment</strong> — Position, department, supervisor, employee ID, date joined, contract type, emergency contact.</li>
                    <li><strong>Files</strong> — HR documents kept on your record (contracts, letters, certificates). Only HR/administrators can upload or delete.</li>
                    <li><strong>Roles</strong>, <strong>Edit</strong> and <strong>Security</strong> — Visible to administrators who manage users (see User Accounts).</li>
                </ul>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Keep your details current.</strong> Your department, supervisor and phone number are shown to leave approvers. If anything is wrong, ask HR to correct it before you apply for leave.</div>
                </div>

                {{-- ============================== DASHBOARD ============================== --}}
                @elseif ($activeSection === 'dashboard')
                <h2><i class="fas fa-tachometer-alt mr-2" style="color:#1d4ed8;"></i> Dashboard Overview</h2>

                <p>The dashboard is your home page when you log in. What it shows depends on your role — there are two views.</p>

                <h3>Employee Dashboard</h3>
                <p>Shown to staff without content or management permissions.</p>
                <ul>
                    <li><strong>Announcements</strong> card — number of notices. Click to open your announcements.</li>
                    <li><strong>Documents</strong> card — number of shared documents available to you.</li>
                    <li><strong>My Leave Requests</strong> card — your applications. Click to open My Leave.</li>
                    <li><strong>Dashboard Links</strong> — Shortcuts to Training Center, My Announcements, My Documents and My Leave.</li>
                </ul>

                <h3>Admin / Manager Dashboard</h3>
                <p>Shown to administrators and to anyone who manages projects, news, testimonials, messages, analytics, announcements, documents or leave applications.</p>
                <ul>
                    <li><strong>Stat cards</strong> — Users, Projects, Testimonials, Messages and News. A card is clickable only if you have permission for that area.</li>
                    <li><strong>Dashboard Links</strong> — Shortcuts filtered by your permissions (Translation Projects, News &amp; Updates, Live Analytics, Announcements, Documents, Leave Applications, My Leave, Training Center).</li>
                    <li><strong>Announcements widget</strong> — Latest internal announcements and memos.</li>
                    <li><strong>Charts &amp; panels</strong> — Click Trend (last 14 days), Top Clicked URLs, Projects by Category, News Posts Per Month, URL Clicks (Today / Week / Month), Recent News and Recent Contact Messages.</li>
                    <li><strong>Employee Workspace</strong> — A shortcut panel for your day-to-day employee tools.</li>
                </ul>

                <div class="tip-box tip-success">
                    <i class="fas fa-check-circle"></i>
                    <div><strong>All users</strong> can view the dashboard — it's the default landing page after login.</div>
                </div>

                {{-- ============================== CONTENT MANAGEMENT ============================== --}}
                @elseif ($activeSection === 'content-management')
                <h2><i class="fas fa-edit mr-2" style="color:#059669;"></i> Content Management</h2>

                <p>Content management covers all the information displayed on the public BiLTA website. Each content section follows the same pattern.</p>

                <h3>How Content Modules Work</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Navigate to the Section</h5>
                        <p>Click the relevant item in the sidebar (e.g., "News" under Content Pages).</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>View Existing Items</h5>
                        <p>A table shows all existing items with their status, date, and action buttons.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Create / Edit / Delete</h5>
                        <p>Click <strong>"Add New"</strong> to create, the <strong>edit icon</strong> to modify, or the <strong>delete icon</strong> to remove an item.</p>
                    </div>
                </div>

                <h3>Available Content Sections</h3>

                <h4>Company Information</h4>
                <table class="perm-table">
                    <thead><tr><th>Section</th><th>What It Controls</th><th>Permission</th></tr></thead>
                    <tbody>
                        <tr><td>Home Intro</td><td>Homepage hero section and intro text</td><td>manage-home-intro</td></tr>
                        <tr><td>About Us</td><td>Mission, vision, objectives, descriptions</td><td>manage-about-us</td></tr>
                        <tr><td>Our Values</td><td>Core organisational values</td><td>manage-values</td></tr>
                        <tr><td>Services</td><td>Services offered by BiLTA</td><td>manage-services</td></tr>
                        <tr><td>Contact Us</td><td>Phone, email, address, social media links</td><td>manage-contact-us</td></tr>
                        <tr><td>Chairman Message</td><td>Chairman's message and photo</td><td>manage-chairman-message</td></tr>
                        <tr><td>Partners</td><td>Partner logos and details</td><td>manage-sponsors</td></tr>
                        <tr><td>Our Team</td><td>Leadership team profiles and photos</td><td>manage-team</td></tr>
                        <tr><td>Contact Emails</td><td>Messages from the public Contact Us form; send or reply to emails (see Newsletters &amp; Enquiries)</td><td>view-emails</td></tr>
                        <tr><td>Front Requests</td><td>Newsletter subscribers and partner inquiries from the website (see Newsletters &amp; Enquiries)</td><td>view-front-requests</td></tr>
                    </tbody>
                </table>

                <h4>Content Pages</h4>
                <table class="perm-table">
                    <thead><tr><th>Section</th><th>What It Controls</th><th>Permission</th></tr></thead>
                    <tbody>
                        <tr><td>News</td><td>News articles with images and categories. Use the details page for each article.</td><td>manage-news</td></tr>
                        <tr><td>Newsletters</td><td>Newsletters with PDF attachments that can be emailed to subscribers</td><td>manage-newsletters</td></tr>
                        <tr><td>Projects</td><td>Translation project entries with details, plus a <strong>Projects Map</strong> page</td><td>manage-projects</td></tr>
                        <tr><td>Gallery</td><td>Photo gallery with categories</td><td>manage-gallery</td></tr>
                        <tr><td>Videos</td><td>YouTube video embeds</td><td>manage-videos</td></tr>
                        <tr><td>Audio</td><td>Audio Bible recordings</td><td>manage-audio</td></tr>
                        <tr><td>FAQs</td><td>Frequently asked questions</td><td>manage-faqs</td></tr>
                        <tr><td>Prayer Points</td><td>Weekly prayer entries with scriptures</td><td>manage-prayer-points</td></tr>
                        <tr><td>Testimonies</td><td>Full testimony stories</td><td>manage-testimonies</td></tr>
                        <tr><td>Testimonials</td><td>Short testimonial quotes</td><td>manage-testimonials</td></tr>
                        <tr><td>Categories</td><td>Shared categories for news, projects, etc.</td><td>manage-categories</td></tr>
                        <tr><td>Analytics</td><td>Public website visitor statistics (see Analytics)</td><td>view-analytics</td></tr>
                    </tbody>
                </table>

                <h3>Uploading Images</h3>
                <ul>
                    <li>Most content sections support image uploads via the form.</li>
                    <li>Supported formats: <strong>JPG, PNG, WEBP</strong></li>
                    <li>Size limits differ per page — follow the hint shown on the upload field. Examples: newsletter banner image up to <strong>10 MB</strong>, newsletter PDFs up to <strong>20 MB</strong> each, profile photos up to <strong>2 MB</strong>.</li>
                    <li>Images are automatically resized for thumbnails.</li>
                </ul>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Important:</strong> Always set the <strong>Status</strong> to "Active" for content to appear on the public website. Items with "Inactive" status are hidden from visitors.</div>
                </div>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Cache:</strong> If a change does not show immediately, use <strong>Refresh System Cache</strong> at the bottom of the sidebar.</div>
                </div>

                {{-- ============================== ANNOUNCEMENTS ============================== --}}
                @elseif ($activeSection === 'announcements')
                <h2><i class="fas fa-bullhorn mr-2" style="color:#ea580c;"></i> Announcements &amp; Memos</h2>

                <p>Internal announcements and memos let management communicate with staff. All staff can read them; only authorised users can publish them.</p>

                <h3>Reading Announcements (All Staff)</h3>
                <p>Go to <strong>Internal → Announcements</strong> (permission <code>view-announcements</code>).</p>
                <ul>
                    <li>High-priority items appear first, then newest first.</li>
                    <li>Use the <strong>search box</strong> and the <strong>Type</strong> (Memo / Announcement) and <strong>Priority</strong> filters to find items.</li>
                    <li>An <strong>unread count</strong> is shown at the top. Opening an item marks it as <strong>read</strong>.</li>
                    <li>Attachments can be downloaded from the open item.</li>
                    <li>You only see items that are published, not expired, not archived and addressed to you (everyone, your department, or you personally).</li>
                </ul>

                <h3>Publishing Announcements (Managers)</h3>
                <p>Go to <strong>Internal → Manage Announcements</strong> (permission <code>manage-announcements</code>).</p>

                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Fill in the Details</h5>
                        <p><strong>Title</strong> (required), <strong>Type</strong> (Memo or Announcement), and the message body in the rich-text editor.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Set Dates, Priority and Status</h5>
                        <p><strong>Publish Date</strong> is required. <strong>Expiry Date</strong> is optional and cannot be before the publish date. Choose a priority (Low, Normal, High) and a <strong>Status</strong>.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Choose the Audience</h5>
                        <p><strong>Everyone</strong>, <strong>Specific departments</strong> (select one or more), or <strong>Specific employees</strong> (select one or more). You must pick at least one when using the last two.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div>
                        <h5>Attach Files (optional)</h5>
                        <p>Upload one or more files — up to <strong>20 MB per file</strong>. Existing attachments can be removed when editing.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div>
                        <h5>Email Notification (optional)</h5>
                        <p>Tick <strong>Send email</strong> to queue an email to every active person in the chosen audience. Editing an item does not resend email unless you tick the option again.</p>
                    </div>
                </div>

                <h3>Managing Existing Items</h3>
                <ul>
                    <li><strong>Filters</strong> — search by title; filter by type, priority, visibility and status.</li>
                    <li><strong>Read count</strong> — the table shows how many people have read each item.</li>
                    <li><strong>Archive / Restore</strong> — Archived items disappear from staff view. Toggle <em>Show Archived</em> to see and restore them.</li>
                    <li><strong>Delete</strong> — Permanently removes the item (needs <code>delete-announcements</code> or <code>manage-announcements</code>).</li>
                </ul>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Important:</strong> An announcement is only visible to staff when its <strong>Status is Active</strong>, its <strong>Publish Date has arrived</strong> and it has not expired or been archived. Prefer <strong>Archive</strong> over Delete so there is a record of past notices.</div>
                </div>

                {{-- ============================== DOCUMENTS ============================== --}}
                @elseif ($activeSection === 'documents')
                <h2><i class="fas fa-folder-open mr-2" style="color:#0d9488;"></i> Document Repository</h2>

                <p>The document repository stores shared files (policies, forms, templates) in a folder tree with access control.</p>

                <h3>Browsing and Downloading (All Staff)</h3>
                <p>Go to <strong>Internal → Documents</strong> (permission <code>view-documents</code>).</p>
                <ul>
                    <li>Click a folder to open it. The breadcrumb at the top lets you jump back to a parent folder or the root.</li>
                    <li>The folder tree shows only folders you have access to.</li>
                    <li>Use <strong>Search</strong> to look across folder names, file names and descriptions.</li>
                    <li>Click a column heading (e.g. Name) to <strong>sort</strong>. Use the download action to save a file.</li>
                    <li>Depending on the access you were given on a folder (<strong>view / edit / manage</strong>) you may also be able to upload, rename or share inside it.</li>
                </ul>

                <h3>Managing Documents (Document Managers)</h3>
                <p>Go to <strong>Internal → Manage Documents</strong> (permission <code>manage-documents</code>). Managers see every folder.</p>

                <h4>Creating a Folder</h4>
                <ol>
                    <li>Navigate to where the folder should live (root or inside another folder).</li>
                    <li>Click the new-folder button and enter a <strong>Name</strong> (required) and optional description (max 500 characters).</li>
                    <li>Choose <strong>Visibility</strong>:
                        <ul>
                            <li><strong>Everyone</strong> — all staff with document access</li>
                            <li><strong>Department</strong> — only the departments you select</li>
                            <li><strong>Specific</strong> — only the people you select</li>
                            <li><strong>Private</strong> — only the creator and managers</li>
                        </ul>
                    </li>
                    <li>Save. Use the edit icon on a folder to change these settings later.</li>
                </ol>

                <h4>Uploading Files</h4>
                <ol>
                    <li><strong>Open a folder first</strong> — files cannot be uploaded at the root.</li>
                    <li>Click <strong>Upload</strong>, select one or many files (up to <strong>50 MB each</strong>) and add an optional description.</li>
                    <li>Click upload. Each file keeps its original name and can be renamed later.</li>
                </ol>

                <h4>Sharing a Folder</h4>
                <p>Use the share icon on a folder, choose <strong>Department</strong> or <strong>User</strong>, pick who, and set the permission:</p>
                <table class="perm-table">
                    <thead><tr><th>Permission</th><th>What They Can Do</th></tr></thead>
                    <tbody>
                        <tr><td><strong>View</strong></td><td>See the folder and download its files</td></tr>
                        <tr><td><strong>Edit</strong></td><td>View plus upload and rename files</td></tr>
                        <tr><td><strong>Manage</strong></td><td>Edit plus manage folder settings and sharing</td></tr>
                    </tbody>
                </table>
                <p>Granting access to someone who already has an entry replaces the old entry. Click the remove icon to withdraw access.</p>

                <div class="tip-box tip-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><strong>Warning:</strong> Deleting a folder permanently deletes <strong>all files inside it</strong> and its access settings. Deleting a file removes it from storage.</div>
                </div>

                {{-- ============================== NEWSLETTERS & ENQUIRIES ============================== --}}
                @elseif ($activeSection === 'newsletters-enquiries')
                <h2><i class="fas fa-envelope-open-text mr-2" style="color:#7c3aed;"></i> Newsletters &amp; Enquiries</h2>

                <p>This section covers email newsletters and the messages and requests that come in from the public website.</p>

                <h3>Newsletters</h3>
                <p>Go to <strong>Content Pages → Newsletters</strong> (permission <code>manage-newsletters</code>).</p>
                <table class="perm-table">
                    <thead><tr><th>Field</th><th>Notes</th></tr></thead>
                    <tbody>
                        <tr><td>Title</td><td>Required, max 255 characters</td></tr>
                        <tr><td>Short Description</td><td>Optional, max 500 characters — shown in listings</td></tr>
                        <tr><td>Content</td><td>Optional rich-text body</td></tr>
                        <tr><td>Publish Date</td><td>Required</td></tr>
                        <tr><td>Status</td><td>Required. Must be <strong>Active</strong> before emails can be sent</td></tr>
                        <tr><td>Display Order</td><td>Optional number — lower numbers appear first</td></tr>
                        <tr><td>Newsletter PDF(s)</td><td>Optional, <strong>PDF only</strong>, up to 20 MB each</td></tr>
                        <tr><td>Header Image</td><td>Optional banner image, up to 10 MB</td></tr>
                    </tbody>
                </table>

                <h4>Sending a Newsletter</h4>
                <ol>
                    <li>Create the newsletter and set its status to <strong>Active</strong>.</li>
                    <li>In the table, click the <strong>send email</strong> button on that row.</li>
                    <li>The newsletter is queued to <strong>all subscribers</strong>. The row then records that emails were sent and when.</li>
                </ol>
                <p>Use the <strong>subscribers</strong> toggle at the top to view the subscriber count and list.</p>

                <div class="tip-box tip-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><strong>Note:</strong> A newsletter can only be emailed <strong>once</strong>. Check the content and attachments carefully before sending.</div>
                </div>

                <h3>Contact Emails</h3>
                <p>Go to <strong>Company Information → Contact Emails</strong> (permission <code>view-emails</code>).</p>
                <ul>
                    <li>Lists messages submitted through the public <strong>Contact Us</strong> form (spam-filtered).</li>
                    <li>Use <strong>Send / Reply Email</strong> to write to a <strong>Recipient</strong> with a required <strong>Subject</strong> and <strong>Message</strong>. The email is sent from the system and recorded under your name.</li>
                    <li>Click an item to view it; use <strong>Edit</strong> to update it or <strong>Create New</strong> to start a fresh message.</li>
                </ul>

                <h3>Front Requests</h3>
                <p>Go to <strong>Company Information → Front Requests</strong> (permission <code>view-front-requests</code>). This is a read-only overview of website activity:</p>
                <ul>
                    <li><strong>Newsletter Subscribers</strong> — email addresses and sign-up dates (15 per page).</li>
                    <li><strong>Partner Inquiries</strong> — name, email, message and date from the partner/sponsor form.</li>
                    <li><strong>Summary counts</strong> — subscribers, inquiries, and donation link clicks (and donation totals when tracked).</li>
                </ul>

                {{-- ============================== APPLYING FOR LEAVE ============================== --}}
                @elseif ($activeSection === 'leave-application')
                <h2><i class="fas fa-calendar-check mr-2" style="color:#cd5b13;"></i> Applying for Leave</h2>

                <p>The leave application system allows you to submit leave requests digitally. The form mirrors BiLTA's physical leave application form.</p>

                <h3>Before You Apply</h3>
                <ul>
                    <li>Check your <strong>leave balance</strong> at the top of the "My Leave" page — it shows remaining days per leave type.</li>
                    <li>Ensure your <strong>profile is complete</strong> (department, supervisor, phone number) — this information is shown to approvers.</li>
                    <li>If applying for <strong>Sick Leave or Hospitalisation Leave</strong>, prepare a supporting document (medical certificate).</li>
                    <li>Plan ahead and submit as early as possible. The <strong>start date cannot be in the past</strong> (today or later) and the end date cannot be before the start date.</li>
                    <li>Have your <strong>electronic signature</strong> ready — you sign the form on screen with a mouse, touch screen or stylus.</li>
                </ul>

                <h3>Step-by-Step Application</h3>

                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Open the Leave Form</h5>
                        <p>Go to <strong>Leave Management → My Leave</strong> in the sidebar. Click the <strong>"Apply for Leave"</strong> button.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Review Your Information</h5>
                        <p>Section 1 shows your employee details (auto-filled from your profile). If anything is incorrect, update your profile first.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Select Dates</h5>
                        <p>Choose your <strong>start date</strong> and <strong>end date</strong>. The system automatically calculates working days (excludes weekends) and the resume date.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div>
                        <h5>Choose Leave Type</h5>
                        <p>Select the type of leave (Annual, Sick, Maternity, etc.). If you select "Others", specify the type in the text field that appears.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div>
                        <h5>Provide a Reason</h5>
                        <p>Write at least 10 characters explaining the purpose of your leave. This is visible to all approvers.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">6</div>
                    <div>
                        <h5>Acting Arrangement (if applicable)</h5>
                        <p>If someone will act on your behalf, select the staff member from the dropdown (their phone number auto-fills), or type the acting name, cell number and position manually.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">7</div>
                    <div>
                        <h5>Attach Documents (if required)</h5>
                        <p>Upload supporting documents (medical certificates, etc.). Accepted: PDF, JPG, PNG, DOC, DOCX — max 5 MB.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">8</div>
                    <div>
                        <h5>Sign the Declaration</h5>
                        <p>Draw your <strong>electronic signature</strong> in the signature box (required). Use <strong>Clear signature</strong> to redo it. The application cannot be submitted without it.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">9</div>
                    <div>
                        <h5>Submit</h5>
                        <p>Click <strong>"Submit Leave Application"</strong>. You will receive a confirmation email, and the first approver will be notified automatically.</p>
                    </div>
                </div>

                <h3>What Happens After Submission?</h3>

                <div class="workflow-visual">
                    <div class="wf-stage wf-submit"><i class="fas fa-paper-plane mr-1"></i> You Submit</div>
                    <i class="fas fa-arrow-right wf-arrow"></i>
                    <div class="wf-stage wf-pending"><i class="fas fa-hourglass-half mr-1"></i> Stage 1 Review</div>
                    <i class="fas fa-arrow-right wf-arrow"></i>
                    <div class="wf-stage wf-pending"><i class="fas fa-hourglass-half mr-1"></i> Stage 2 Review</div>
                    <i class="fas fa-arrow-right wf-arrow"></i>
                    <div class="wf-stage wf-approved"><i class="fas fa-check mr-1"></i> Fully Approved</div>
                </div>

                <ul>
                    <li>Your application enters the <strong>approval workflow</strong> configured by the administrator.</li>
                    <li>Each stage is assigned to specific people (by their role). They receive an <strong>email notification</strong>.</li>
                    <li>You receive an email at <strong>every stage</strong> — when approved or rejected.</li>
                    <li>You can <strong>track progress</strong> by clicking "View" on your application — the pipeline shows exactly where it is, who acted, their comments and signatures.</li>
                    <li>Click <strong>Download PDF</strong> in the application view to get a printable copy of the leave form.</li>
                    <li>Your <strong>leave balance is only deducted</strong> once the application is <strong>fully approved</strong> (all stages complete).</li>
                </ul>

                <h3>Cancelling an Application</h3>
                <p>You can cancel your own <strong>pending</strong> application by clicking "Cancel" in the applications table. Once cancelled, it cannot be resubmitted — you'd need to create a new application.</p>

                <div class="tip-box tip-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><strong>Note:</strong> You cannot cancel an application that has already been approved, rejected, or cancelled.</div>
                </div>

                {{-- ============================== APPROVING LEAVE ============================== --}}
                @elseif ($activeSection === 'leave-approval')
                <h2><i class="fas fa-check-double mr-2" style="color:#dc2626;"></i> Approving / Rejecting Leave</h2>

                <p>If your role is assigned to an approval stage in the leave workflow, you will receive email notifications when applications need your review. You need the <code>approve-reject-leave</code> permission <strong>and</strong> the role assigned to the current stage.</p>

                <h3>Where to Approve</h3>
                <p>You can approve or reject leave from <strong>two places</strong>:</p>
                <ul>
                    <li><strong>My Leave page</strong> — Click "View" on an application assigned to you. If you have the role to act at the current stage, the "Your Action Required" panel appears at the bottom.</li>
                    <li><strong>All Applications page</strong> (<code>manage-leave-applications</code>, <code>view-all-leave-applications</code> or <code>approve-reject-leave</code>) — Click "View" then use the approve/reject buttons.</li>
                </ul>

                <h3>Which Applications Can You See?</h3>
                <table class="perm-table">
                    <thead><tr><th>Your Access</th><th>Applications Visible</th></tr></thead>
                    <tbody>
                        <tr><td><code>manage-leave-applications</code>, <code>view-all-leave-applications</code> or Senior Executive</td><td>All applications from all employees</td></tr>
                        <tr><td>Approver (<code>approve-reject-leave</code>)</td><td>Your own, applications from people you supervise, and from your department(s)</td></tr>
                        <tr><td>Supervisor</td><td>Your own and applications from your direct reports</td></tr>
                    </tbody>
                </table>
                <p>The page shows summary counts (pending, approved, rejected, total for the year) and can be filtered by <strong>status</strong>, <strong>year</strong> and <strong>employee</strong>. Pending items are listed first.</p>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Rules:</strong> You can never approve or reject <em>your own</em> application. For a <strong>Supervisor</strong> stage, only the applicant's assigned supervisor can act.</div>
                </div>

                <h3>Step-by-Step Approval</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Open the Application</h5>
                        <p>Click <strong>"View"</strong> on the application you need to review. Read all details carefully — employee info, dates, reason, documents, acting arrangement and the applicant's signature.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Check the Workflow Pipeline</h5>
                        <p>The pipeline section shows all stages, who has already acted, and where the application currently is. Your stage will be highlighted in yellow.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Enter Your Reason</h5>
                        <p>In the <strong>"Your Action Required"</strong> section, type your reason or comment (required, minimum 3 characters). This is recorded in the audit trail and sent to the applicant.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div>
                        <h5>Sign (optional)</h5>
                        <p>You may draw your electronic signature. It is stored with your decision and appears in the approval history and PDF.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div>
                        <h5>Approve or Reject</h5>
                        <p>Click <strong>"Approve Application"</strong> (green) or <strong>"Reject Application"</strong> (red). A confirmation dialog will appear.</p>
                    </div>
                </div>

                <h3>What Happens After Your Action?</h3>
                <table class="perm-table">
                    <thead><tr><th>Action</th><th>Result</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Approve</strong> (not final stage)</td><td>Application moves to the next stage. Next approver is notified by email. Applicant receives an update email.</td></tr>
                        <tr><td><strong>Approve</strong> (final stage)</td><td>Application is <strong>fully approved</strong>. Leave balance is deducted. Applicant receives a "fully approved" email.</td></tr>
                        <tr><td><strong>Reject</strong> (any stage)</td><td>Application is immediately <strong>rejected</strong>. Workflow terminates. Applicant receives a rejection email with your comment.</td></tr>
                    </tbody>
                </table>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Important:</strong> Rejection at <em>any</em> stage terminates the entire application. There is no "return for revision" — the employee must submit a new application.</div>
                </div>

                {{-- ============================== LEAVE ADMIN SETUP ============================== --}}
                @elseif ($activeSection === 'leave-management')
                <h2><i class="fas fa-cogs mr-2" style="color:#0891b2;"></i> Leave Administration Setup</h2>

                <p>HR and leave managers configure the leave system. This section covers setup tasks.</p>

                <h3>Leave Types</h3>
                <p>Navigate to <strong>Leave Management → Leave → Leave Types</strong> (<code>manage-leave-types</code>) to manage the types of leave available.</p>
                <ul>
                    <li><strong>Name</strong> — e.g., "Annual Leave", "Sick Leave"</li>
                    <li><strong>Default Days</strong> — Standard allocation per year (e.g., 24 for Annual)</li>
                    <li><strong>Requires Document</strong> — If yes, the form shows a reminder to upload a certificate</li>
                    <li><strong>Is Paid</strong> — Whether leave days are paid</li>
                    <li><strong>Carry Over</strong> — Whether unused days can roll into next year</li>
                    <li><strong>Max Carry Over Days</strong> — Maximum days that can be carried over</li>
                </ul>

                <h4>Default Leave Types</h4>
                <table class="perm-table">
                    <thead><tr><th>Type</th><th>Default Days</th><th>Document</th><th>Carry Over</th></tr></thead>
                    <tbody>
                        <tr><td>Annual Leave</td><td>24</td><td>No</td><td>Yes (max 5)</td></tr>
                        <tr><td>Sick Leave</td><td>26</td><td>Required</td><td>No</td></tr>
                        <tr><td>Hospitalisation Leave</td><td>26</td><td>Required</td><td>No</td></tr>
                        <tr><td>Maternity Leave</td><td>90</td><td>Required</td><td>No</td></tr>
                        <tr><td>Study / Exam Leave</td><td>10</td><td>Required</td><td>No</td></tr>
                        <tr><td>Emergency Leave</td><td>5</td><td>No</td><td>No</td></tr>
                        <tr><td>Others</td><td>0 (unpaid)</td><td>No</td><td>No — applicant must specify the type</td></tr>
                    </tbody>
                </table>

                <h3>Leave Balances</h3>
                <p>Navigate to <strong>Leave Management → Leave → Leave Balances</strong> (<code>manage-leave-balances</code>). Use the year and employee filters to find records.</p>
                <ul>
                    <li><strong>Individual Allocation</strong> — Select an employee, leave type, total days, and carried-over days, then save.</li>
                    <li><strong>Bulk Allocation</strong> — Click "Bulk Allocate" to create default balances for ALL active users for the selected year. Uses the "Default Days" from each leave type.</li>
                    <li><strong>Delete</strong> — A balance record can be removed if created in error.</li>
                    <li><strong>Balance Formula:</strong> <code>Remaining = (Total Days + Carried Over) − Used Days</code></li>
                </ul>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Tip:</strong> Run "Bulk Allocate" at the start of each year to set up all employee balances automatically.</div>
                </div>

                <h3>Approval Workflows</h3>
                <p>Navigate to <strong>Leave Management → Leave → Approval Workflows</strong> (<code>manage-approval-workflows</code>).</p>

                <h4>Creating a Workflow</h4>
                <ol>
                    <li>Click <strong>"New Workflow"</strong>.</li>
                    <li>Enter a name (e.g., "BiLTA Leave Workflow") and set Form Type to "Leave".</li>
                    <li>Mark it as <strong>Active</strong> — only one active workflow per form type is used.</li>
                    <li>Save the workflow.</li>
                </ol>

                <h4>Adding Stages</h4>
                <ol>
                    <li>In the workflow detail, click <strong>"Add Stage"</strong>.</li>
                    <li>Enter a name (e.g., "Supervisor Review"), select a <strong>Role</strong>, and set the <strong>Stage Order</strong> (1, 2, 3...). For a stage assigned to the <strong>Supervisor</strong> role, the applicant’s own assigned supervisor is the approver.</li>
                    <li>The system auto-assigns the first stage as "Start" and the last as "End".</li>
                    <li>Approvers must have the <strong>Approve or Reject Leave Applications</strong> permission and the assigned stage role. For Supervisor stages, only the applicant’s designated supervisor can act.</li>
                </ol>

                <div class="tip-box tip-success">
                    <i class="fas fa-lightbulb"></i>
                    <div><strong>Example Setup:</strong><br>
                        Stage 1: "Supervisor Review" → Supervisor role (the applicant's own supervisor)<br>
                        Stage 2: "HR Approval" → HR Manager role<br>
                        Stage 3: "Executive Sign-off" → Senior Executive role</div>
                </div>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Before staff can apply:</strong> an <strong>active workflow with at least one stage</strong> must exist. Otherwise applicants see "No active approval workflow is configured".</div>
                </div>

                {{-- ============================== DEPARTMENTS ============================== --}}
                @elseif ($activeSection === 'departments')
                <h2><i class="fas fa-building mr-2" style="color:#4f46e5;"></i> Departments</h2>

                <p>Navigate to <strong>Departments</strong> in the sidebar (permission <code>manage-departments</code>, or the specific create / edit / delete permissions) to manage organisational departments.</p>

                <h3>Department Fields</h3>
                <ul>
                    <li><strong>Name</strong> — Required, max 100 characters (e.g., "Human Resources")</li>
                    <li><strong>Code</strong> — Optional short code, max 20 characters (e.g., "HR")</li>
                    <li><strong>Description</strong> — Optional, max 500 characters</li>
                    <li><strong>Head</strong> — Assign a user as department head</li>
                    <li><strong>Status</strong> — Active or Inactive</li>
                </ul>

                <p>The table also shows how many members each department has. Departments are used for user profiles, announcement targeting, document sharing and leave visibility.</p>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Deleting:</strong> A department that still has members (primary or additional responsibility) cannot be deleted. Reassign those members first.</div>
                </div>

                <h3>Default Departments</h3>
                <p>The system comes pre-configured with 10 departments:</p>
                <ol>
                    <li>Human Resources</li>
                    <li>Finance & Accounts</li>
                    <li>Translation</li>
                    <li>Scripture Engagement</li>
                    <li>Information Technology</li>
                    <li>Administration</li>
                    <li>Programs & Projects</li>
                    <li>Literacy & Education</li>
                    <li>Communications & Media</li>
                    <li>Executive Management</li>
                </ol>

                {{-- ============================== POSITIONS ============================== --}}
                @elseif ($activeSection === 'positions')
                <h2><i class="fas fa-id-badge mr-2" style="color:#0284c7;"></i> Positions</h2>

                <p>Positions are the job titles used on staff profiles. Navigate to <strong>Positions</strong> in the sidebar (permission <code>manage-positions</code>, or the specific create / edit / delete permissions).</p>

                <h3>Position Fields</h3>
                <ul>
                    <li><strong>Name</strong> — Required, max 100 characters (e.g., "Translation Consultant")</li>
                    <li><strong>Code</strong> — Optional, max 20 characters. Saved in capital letters.</li>
                    <li><strong>Department</strong> — Optional link to a department</li>
                    <li><strong>Description</strong> — Optional</li>
                    <li><strong>Status</strong> — Active or Inactive. Only <strong>Active</strong> positions appear in the user forms.</li>
                </ul>

                <h3>Finding Positions</h3>
                <p>Use the <strong>search box</strong> (name, code or description) and the <strong>department filter</strong>. The table shows how many employees hold each position.</p>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Deleting:</strong> A position that is assigned to employees cannot be deleted. Reassign those employees first.</div>
                </div>

                {{-- ============================== USER MANAGEMENT ============================== --}}
                @elseif ($activeSection === 'user-management')
                <h2><i class="fas fa-users-cog mr-2" style="color:#be185d;"></i> User Accounts</h2>

                <p>Navigate to <strong>System → User Accounts</strong> (permission <code>manage-users</code>) to create and manage user accounts. Use the search box to find people by name, email, phone or employee ID.</p>

                <h3>Creating a User</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Basic Information</h5>
                        <p>Enter <strong>name, email, phone and status</strong> (all required), plus NRC number and MAN number if available. You do <strong>not</strong> set a password — the system generates a temporary one.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Employment Details</h5>
                        <p>Set the position and department (dropdowns), supervisor, employee ID, date of birth, gender, date joined, and contract type (permanent, contract, part-time, intern, volunteer).</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Additional Responsibilities (optional)</h5>
                        <p>If the person also works in other departments, add each extra department (and position) once. The primary department cannot be repeated here.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div>
                        <h5>Emergency Contact</h5>
                        <p>Enter emergency contact name, phone number, and the employee's physical address.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div>
                        <h5>Save</h5>
                        <p>The user gets the <strong>Employee</strong> role by default and a <strong>welcome email with a temporary password</strong>. They must change it at first login. If the email cannot be sent, the account is still created — use an OTP reset to give them access.</p>
                    </div>
                </div>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Supervisors:</strong> The supervisor dropdown lists only users who hold the <strong>Supervisor</strong> role. Assign that role first if someone is missing.</div>
                </div>

                <h3>Viewing and Editing a User</h3>
                <p>Click a user's name to open their profile. It has tabs:</p>
                <table class="perm-table">
                    <thead><tr><th>Tab</th><th>Purpose</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Profile</strong></td><td>Basic information and profile photo (images up to 2 MB, can be removed)</td></tr>
                        <tr><td><strong>Employment</strong></td><td>Position, department, supervisor, contract and emergency details</td></tr>
                        <tr><td><strong>Files</strong></td><td>HR documents for the employee (see below)</td></tr>
                        <tr><td><strong>Roles</strong></td><td>Attach or detach roles (<code>manage-user-roles</code>)</td></tr>
                        <tr><td><strong>Edit</strong></td><td>Change any profile field</td></tr>
                        <tr><td><strong>Security</strong></td><td>Password reset options</td></tr>
                    </tbody>
                </table>

                <h4>Employee Files</h4>
                <ul>
                    <li>Upload PDF, Word, Excel, PowerPoint, image, TXT or CSV files, up to <strong>10 MB</strong>.</li>
                    <li>Pick a <strong>file type</strong> (e.g. Offer Letter, Employment Contract, Resume / CV, Qualifications, Performance Review, Warning Letter, Training Certificate, Resignation Letter, Other), plus an optional title and description.</li>
                    <li>Filter by type or date range and <strong>Export CSV</strong> of the file list.</li>
                    <li>Only authorised administrators/HR can upload or delete files.</li>
                </ul>

                <h4>Resetting a Password</h4>
                <ul>
                    <li><strong>OTP reset</strong> (Security tab) — Generates a 6-digit one-time password valid for <strong>72 hours</strong>, emails it to the user and shows it to you once. The user must set a new password at next login. You cannot OTP-reset your own account.</li>
                    <li><strong>Manual reset</strong> — Enter a new password (min 8 characters, confirmed).</li>
                </ul>

                <h3>Password Enforcement (Administrators)</h3>
                <p>On the User Accounts list, administrators see two bulk actions:</p>
                <ul>
                    <li><strong>Send password reminders</strong> — Emails everyone who still has to change their temporary password (a reminder is sent at most once every 7 days per person).</li>
                    <li><strong>Force reset for inactive users</strong> — Issues new OTP passwords to users who have not logged in for <strong>90 days</strong>. You are asked to confirm first. Eligible administrators are excluded.</li>
                </ul>

                <div class="tip-box tip-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><strong>Deleting users</strong> needs the <code>delete-users</code> permission (or an Administrator role). Deleted accounts cannot be recovered — set the status to Inactive instead when someone leaves.</div>
                </div>

                <h3>User Fields Reference</h3>
                <table class="perm-table">
                    <thead><tr><th>Field</th><th>Description</th><th>Required</th></tr></thead>
                    <tbody>
                        <tr><td>Name</td><td>Full name</td><td>Yes</td></tr>
                        <tr><td>Email</td><td>Login email (must be unique)</td><td>Yes</td></tr>
                        <tr><td>Phone</td><td>Mobile number</td><td>Yes</td></tr>
                        <tr><td>Status</td><td>Active / Inactive etc.</td><td>Yes</td></tr>
                        <tr><td>NRC Number</td><td>National Registration Card</td><td>No</td></tr>
                        <tr><td>MAN Number</td><td>BiLTA MAN number</td><td>No</td></tr>
                        <tr><td>Employee ID</td><td>Internal employee reference</td><td>No</td></tr>
                        <tr><td>Position</td><td>Job title (from Positions)</td><td>No</td></tr>
                        <tr><td>Department</td><td>Linked to Departments table</td><td>No</td></tr>
                        <tr><td>Supervisor</td><td>Direct reporting manager (must hold the Supervisor role)</td><td>No</td></tr>
                        <tr><td>Role(s)</td><td>Determines permissions. New users start as Employee.</td><td>Assigned after creation</td></tr>
                    </tbody>
                </table>

                {{-- ============================== ROLES & PERMISSIONS ============================== --}}
                @elseif ($activeSection === 'roles-permissions')
                <h2><i class="fas fa-shield-alt mr-2" style="color:#cd5b13;"></i> Roles & Permissions</h2>

                <p>The system uses Role-Based Access Control (RBAC). Each user is assigned one or more roles, and each role has a set of permissions that control what the user can see and do.</p>

                <h3>Default Roles</h3>
                <table class="perm-table">
                    <thead><tr><th>Role</th><th>Access Level</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Super Administrator</strong></td><td>Unrestricted access to every module and setting</td></tr>
                        <tr><td><strong>Administrator</strong></td><td>Full administrative access to all features</td></tr>
                        <tr><td><strong>System Administrator</strong></td><td>Assists Super Admins: user accounts, statuses, analytics, departments, positions, announcements and documents</td></tr>
                        <tr><td><strong>Content Manager</strong></td><td>All public website content, enquiries, analytics, plus announcements and documents management</td></tr>
                        <tr><td><strong>HR Manager</strong></td><td>Users, HR profiles, departments, positions, full leave management (types, balances, workflows, approvals), announcements and documents</td></tr>
                        <tr><td><strong>HR Officer</strong></td><td>Day-to-day HR: users, departments, positions, leave applications, types and balances</td></tr>
                        <tr><td><strong>Finance</strong></td><td>Financial permissions plus the employee basics</td></tr>
                        <tr><td><strong>Employee</strong></td><td>Baseline for every staff member: dashboard, apply for leave, announcements, documents, training</td></tr>
                        <tr><td><strong>Supervisor</strong></td><td>Employee access plus approving leave for direct reports</td></tr>
                        <tr><td><strong>Company Secretariat</strong></td><td>Leave approval, view all leave applications, manage announcements and documents</td></tr>
                        <tr><td><strong>Senior Executive</strong></td><td>Company-wide leave visibility and approval, financial view, analytics</td></tr>
                        <tr><td><strong>Editor</strong></td><td>Create and edit website content (no system administration)</td></tr>
                        <tr><td><strong>Viewer</strong></td><td>Read-only dashboard, enquiries and analytics</td></tr>
                        <tr><td><strong>Leave roles</strong></td><td>Leave Applicant, Leave Approver, Approver, Leave Officer, Leave Workflow Manager and Leave Manager — focused combinations of the leave permissions</td></tr>
                    </tbody>
                </table>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Tip:</strong> Every role includes <code>view-training</code>, so everyone can open this Training Center. A person can hold several roles — e.g. <em>Employee</em> + <em>Supervisor</em> + <em>HR Officer</em>.</div>
                </div>

                <h3>How Permissions Work</h3>
                <ul>
                    <li>Each menu item in the sidebar is protected by a permission (e.g., "manage-news").</li>
                    <li>If your role does not include a permission, you <strong>will not see</strong> the menu item and <strong>cannot access</strong> the page.</li>
                    <li>Some areas have finer permissions — e.g. <code>create-departments</code>, <code>edit-departments</code>, <code>delete-departments</code>, <code>delete-announcements</code>, <code>delete-documents</code>, <code>delete-leave-applications</code>.</li>
                    <li>Administrators can customise which permissions belong to each role.</li>
                </ul>

                <h3>Managing Roles</h3>
                <ol>
                    <li>Go to <strong>System → System Settings → Roles</strong> (<code>manage-roles</code>).</li>
                    <li>Click on a role to view/edit its permissions.</li>
                    <li>Check or uncheck permissions, then save.</li>
                </ol>

                <h3>Permissions and Statuses</h3>
                <ul>
                    <li><strong>Permissions</strong> (<code>manage-permissions</code>) — The master list of permissions that can be given to roles.</li>
                    <li><strong>Statuses</strong> (<code>manage-statuses</code>) — The status values (e.g. Active, Inactive) used across the system for content, users, departments and more.</li>
                </ul>

                <div class="tip-box tip-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><strong>Warning:</strong> Be careful when modifying the Administrator role. Removing critical permissions (like <code>manage-users</code> or <code>manage-roles</code>) could lock you out of the system.</div>
                </div>

                {{-- ============================== ANALYTICS ============================== --}}
                @elseif ($activeSection === 'analytics')
                <h2><i class="fas fa-chart-bar mr-2" style="color:#6366f1;"></i> Analytics</h2>

                <p>The analytics dashboard shows visitor activity on the public BiLTA website. Navigate to <strong>Content Pages → Analytics</strong> in the sidebar.</p>

                <h3>What's Tracked</h3>
                <ul>
                    <li><strong>Total Clicks</strong> — Number of page views</li>
                    <li><strong>Unique Visitors</strong> — Distinct visitor sessions</li>
                    <li><strong>Top Pages</strong> — Most visited URLs</li>
                    <li><strong>Countries</strong> — Visitor locations with geolocation</li>
                    <li><strong>Browsers</strong> — Chrome, Firefox, Safari, etc.</li>
                    <li><strong>Devices</strong> — Desktop, mobile, tablet breakdown</li>
                    <li><strong>Referrers</strong> — Where visitors came from</li>
                    <li><strong>Daily Trends</strong> — Click trends over time</li>
                </ul>

                <h3>Filtering</h3>
                <p>Use the date range picker at the top of the analytics page to filter data by a specific period.</p>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Note:</strong> Admin panel pages are NOT tracked in website analytics — it only captures public website visits. Bot traffic is automatically excluded.</div>
                </div>

                <h3>User Usage Analytics</h3>
                <p>Administrators with <code>manage-users</code> can open <strong>System → User Usage Analytics</strong> to see how staff use the system over the <strong>last 30 days</strong>:</p>
                <ul>
                    <li><strong>Total page views</strong> and number of <strong>active users</strong></li>
                    <li><strong>Recent logins</strong> and how many people have <strong>never logged in</strong></li>
                    <li><strong>Top pages</strong> visited by logged-in users</li>
                    <li>A per-user table ranked by page views, with login counts</li>
                </ul>
                <p>Use it to find staff who have not yet activated their accounts and may need a password reminder.</p>

                {{-- ============================== FAQ ============================== --}}
                @elseif ($activeSection === 'faq')
                <h2><i class="fas fa-question-circle mr-2" style="color:#64748b;"></i> FAQ & Troubleshooting</h2>

                <h3>Frequently Asked Questions</h3>

                <h4>Q: I can't see certain menu items in the sidebar.</h4>
                <p><strong>A:</strong> Your role doesn't include the required permission. Ask your administrator to assign the needed permissions to your role, or assign you a different role.</p>

                <h4>Q: My leave balance shows 0 days remaining.</h4>
                <p><strong>A:</strong> Either your balance hasn't been allocated for this year, or all days have been used. Ask your HR administrator to check your balance in <strong>Leave Management → Leave → Leave Balances</strong>.</p>

                <h4>Q: I submitted a leave application but no one is approving it.</h4>
                <p><strong>A:</strong> Check the workflow pipeline in your application detail view. It shows exactly which stage and role is pending. If no users are assigned to that role, contact your administrator to assign the correct roles to approvers.</p>

                <h4>Q: I approved an application but the balance didn't change.</h4>
                <p><strong>A:</strong> Leave balance is only deducted when the <strong>final stage</strong> is approved. If there are more stages remaining, the balance won't change until full approval.</p>

                <h4>Q: I made a mistake in a leave application. Can I edit it?</h4>
                <p><strong>A:</strong> Leave applications cannot be edited after submission. You can <strong>cancel</strong> a pending application and submit a new one with the correct information.</p>

                <h4>Q: Images I uploaded are not showing on the website.</h4>
                <p><strong>A:</strong> Ensure the item's <strong>status is set to "Active"</strong>. Only active items appear on the public website.</p>

                <h4>Q: The system feels slow or shows stale data.</h4>
                <p><strong>A:</strong> Try the <strong>"Refresh System Cache"</strong> button at the bottom of the sidebar to clear all caches.</p>

                <h4>Q: I forgot my password.</h4>
                <p><strong>A:</strong> Use the "Forgot Password?" link on the login page, or ask an administrator to issue a one-time password (OTP) from the user's <strong>Security</strong> tab. You will be asked to choose a new password at next login.</p>

                <h4>Q: I was told I must change my password before I can continue.</h4>
                <p><strong>A:</strong> This happens after your account is created or reset. Enter a new password of at least 8 characters, confirm it and save. You will then be taken to the dashboard.</p>

                <h4>Q: I can't submit my leave application — it says no workflow is configured.</h4>
                <p><strong>A:</strong> An administrator must create and activate a leave approval workflow with at least one stage. See <strong>Leave Admin Setup</strong>.</p>

                <h4>Q: The leave form won't submit.</h4>
                <p><strong>A:</strong> Check that the start date is today or later, the end date is not before the start date, the reason is at least 10 characters, and that you have <strong>signed</strong> in the signature box.</p>

                <h4>Q: I can't upload a file to the Document Repository.</h4>
                <p><strong>A:</strong> Open a folder first — uploads are not allowed at the root — and make sure you have <strong>edit</strong> or <strong>manage</strong> access to that folder. Files must be 50 MB or smaller.</p>

                <h4>Q: I can't see an announcement that a colleague can see.</h4>
                <p><strong>A:</strong> Announcements can be targeted at specific departments or people, and only appear once published, active and not expired or archived.</p>

                <h4>Q: A newsletter won't send.</h4>
                <p><strong>A:</strong> Its status must be <strong>Active</strong>, and a newsletter can only be emailed once.</p>

                <div class="tip-box tip-info">
                    <i class="fas fa-headset"></i>
                    <div><strong>Still need help?</strong> Contact your system administrator or the IT department for further assistance.</div>
                </div>

                @endif

            </div>
        </div>
    </div>
</div>
