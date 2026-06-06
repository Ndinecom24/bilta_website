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
                        <p>Enter the email address and password provided by your administrator. Click "Login".</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>You're In!</h5>
                        <p>You will be redirected to the admin dashboard. The sidebar on the left shows all sections you have access to.</p>
                    </div>
                </div>

                <h3>Understanding the Interface</h3>
                <ul>
                    <li><strong>Top Navigation Bar</strong> — Shows your name, profile link, date, and logout option.</li>
                    <li><strong>Left Sidebar</strong> — Contains all navigation menus grouped by category. You only see menus you have permission to access.</li>
                    <li><strong>Main Content Area</strong> — Where all forms, tables, and content are displayed.</li>
                    <li><strong>Alerts</strong> — Green messages = success. Red messages = errors. They appear at the top of pages after actions.</li>
                </ul>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Tip:</strong> If you cannot see a menu item, it means your role does not include that permission. Contact your administrator to request access.</div>
                </div>

                <h3>Your Profile</h3>
                <p>Click your name in the top-right corner and select <strong>"My Profile"</strong> to view or update your information. Your profile includes:</p>
                <ul>
                    <li>Basic info (name, email, phone)</li>
                    <li>Employment details (position, department, employee ID, date joined)</li>
                    <li>Emergency contact information</li>
                </ul>

                {{-- ============================== DASHBOARD ============================== --}}
                @elseif ($activeSection === 'dashboard')
                <h2><i class="fas fa-tachometer-alt mr-2" style="color:#1d4ed8;"></i> Dashboard Overview</h2>

                <p>The dashboard is your home page when you log in. It provides a quick overview of the system.</p>

                <h3>What You See</h3>
                <ul>
                    <li><strong>Welcome card</strong> — Greets you by name with the current date.</li>
                    <li><strong>Quick stats</strong> — Summary cards showing counts (content items, users, etc.).</li>
                    <li><strong>Recent activity</strong> — Latest updates and actions across the system.</li>
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
                        <tr><td>Sponsors</td><td>Sponsor logos and details</td><td>manage-sponsors</td></tr>
                        <tr><td>Our Team</td><td>Leadership team profiles and photos</td><td>manage-team</td></tr>
                    </tbody>
                </table>

                <h4>Content Pages</h4>
                <table class="perm-table">
                    <thead><tr><th>Section</th><th>What It Controls</th><th>Permission</th></tr></thead>
                    <tbody>
                        <tr><td>News</td><td>News articles with images and categories</td><td>manage-news</td></tr>
                        <tr><td>Projects</td><td>Translation project entries with details</td><td>manage-projects</td></tr>
                        <tr><td>Gallery</td><td>Photo gallery with categories</td><td>manage-gallery</td></tr>
                        <tr><td>Videos</td><td>YouTube video embeds</td><td>manage-videos</td></tr>
                        <tr><td>Audio</td><td>Audio Bible recordings</td><td>manage-audio</td></tr>
                        <tr><td>FAQs</td><td>Frequently asked questions</td><td>manage-faqs</td></tr>
                        <tr><td>Prayer Points</td><td>Weekly prayer entries with scriptures</td><td>manage-prayer-points</td></tr>
                        <tr><td>Testimonies</td><td>Full testimony stories</td><td>manage-testimonies</td></tr>
                        <tr><td>Testimonials</td><td>Short testimonial quotes</td><td>manage-testimonials</td></tr>
                        <tr><td>Categories</td><td>Shared categories for news, projects, etc.</td><td>manage-categories</td></tr>
                    </tbody>
                </table>

                <h3>Uploading Images</h3>
                <ul>
                    <li>Most content sections support image uploads via the form.</li>
                    <li>Supported formats: <strong>JPG, PNG, WEBP</strong></li>
                    <li>Maximum file size: <strong>5 MB</strong></li>
                    <li>Images are automatically resized for thumbnails.</li>
                </ul>

                <div class="tip-box tip-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div><strong>Important:</strong> Always set the <strong>Status</strong> to "Active" for content to appear on the public website. Items with "Inactive" status are hidden from visitors.</div>
                </div>

                {{-- ============================== APPLYING FOR LEAVE ============================== --}}
                @elseif ($activeSection === 'leave-application')
                <h2><i class="fas fa-calendar-check mr-2" style="color:#cd5b13;"></i> Applying for Leave</h2>

                <p>The leave application system allows you to submit leave requests digitally. The form mirrors BiLTA's physical leave application form.</p>

                <h3>Before You Apply</h3>
                <ul>
                    <li>Check your <strong>leave balance</strong> at the top of the "My Leave" page — it shows remaining days per leave type.</li>
                    <li>Ensure your <strong>profile is complete</strong> (department, supervisor, phone number) — this information is shown to approvers.</li>
                    <li>If applying for <strong>Sick Leave or Hospitalisation Leave</strong>, prepare a supporting document (medical certificate).</li>
                    <li>Submit your application at least <strong>3 working days</strong> before the leave start date.</li>
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
                        <p>If you are a Team Leader or Deputy Team Leader, select the staff member who will act on your behalf from the dropdown. Their phone number auto-fills.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">7</div>
                    <div>
                        <h5>Attach Documents (if required)</h5>
                        <p>Upload supporting documents (medical certificates, etc.). Accepted: PDF, JPG, PNG, DOC — max 5MB.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">8</div>
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
                    <li>You can <strong>track progress</strong> by clicking "View" on your application — the pipeline shows exactly where it is.</li>
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

                <p>If your role is assigned to an approval stage in the leave workflow, you will receive email notifications when applications need your review.</p>

                <h3>Where to Approve</h3>
                <p>You can approve or reject leave from <strong>two places</strong>:</p>
                <ul>
                    <li><strong>My Leave page</strong> — Click "View" on any application. If you have the role to act at the current stage, the "Your Action Required" panel appears at the bottom.</li>
                    <li><strong>All Applications page</strong> — (requires <code>manage-leave-applications</code> permission) — Shows all applications from all employees. Click "View" then use the approve/reject buttons.</li>
                </ul>

                <h3>Step-by-Step Approval</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Open the Application</h5>
                        <p>Click <strong>"View"</strong> on the application you need to review. Read all details carefully — employee info, dates, reason, documents, acting arrangement.</p>
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

                <p>Administrators and content managers can configure the leave system. This section covers setup tasks.</p>

                <h3>Leave Types</h3>
                <p>Navigate to <strong>Leave Management → Leave Types</strong> to manage the types of leave available.</p>
                <ul>
                    <li><strong>Name</strong> — e.g., "Annual Leave", "Sick Leave"</li>
                    <li><strong>Default Days</strong> — Standard allocation per year (e.g., 24 for Annual)</li>
                    <li><strong>Requires Document</strong> — If yes, the form shows a reminder to upload a certificate</li>
                    <li><strong>Is Paid</strong> — Whether leave days are paid</li>
                    <li><strong>Carry Over</strong> — Whether unused days can roll into next year</li>
                    <li><strong>Max Carry Over Days</strong> — Maximum days that can be carried over</li>
                </ul>

                <h3>Leave Balances</h3>
                <p>Navigate to <strong>Leave Management → Leave Balances</strong>.</p>
                <ul>
                    <li><strong>Individual Allocation</strong> — Select an employee, leave type, total days, and carried-over days, then save.</li>
                    <li><strong>Bulk Allocation</strong> — Click "Bulk Allocate" to create default balances for ALL active users for the selected year. Uses the "Default Days" from each leave type.</li>
                    <li><strong>Balance Formula:</strong> <code>Remaining = (Total Days + Carried Over) − Used Days</code></li>
                </ul>

                <div class="tip-box tip-info">
                    <i class="fas fa-info-circle"></i>
                    <div><strong>Tip:</strong> Run "Bulk Allocate" at the start of each year to set up all employee balances automatically.</div>
                </div>

                <h3>Approval Workflows</h3>
                <p>Navigate to <strong>Leave Management → Approval Workflows</strong>.</p>

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
                    <li>Enter a name (e.g., "Supervisor Review"), select a <strong>Role</strong>, and set the <strong>Stage Order</strong> (1, 2, 3...).</li>
                    <li>The system auto-assigns the first stage as "Start" and the last as "End".</li>
                    <li>Any user with the assigned role can approve at that stage.</li>
                </ol>

                <div class="tip-box tip-success">
                    <i class="fas fa-lightbulb"></i>
                    <div><strong>Example Setup:</strong><br>
                        Stage 1: "Supervisor Review" → Editor role<br>
                        Stage 2: "HR Approval" → Content Manager role<br>
                        Stage 3: "Director Sign-off" → Admin role</div>
                </div>

                {{-- ============================== DEPARTMENTS ============================== --}}
                @elseif ($activeSection === 'departments')
                <h2><i class="fas fa-building mr-2" style="color:#4f46e5;"></i> Departments</h2>

                <p>Navigate to <strong>Departments</strong> in the sidebar to manage organisational departments.</p>

                <h3>Department Fields</h3>
                <ul>
                    <li><strong>Name</strong> — Department name (e.g., "Human Resources")</li>
                    <li><strong>Code</strong> — Short code (e.g., "HR")</li>
                    <li><strong>Description</strong> — Brief description of the department</li>
                    <li><strong>Head</strong> — Assign a user as department head</li>
                    <li><strong>Status</strong> — Active or Inactive</li>
                </ul>

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

                {{-- ============================== USER MANAGEMENT ============================== --}}
                @elseif ($activeSection === 'user-management')
                <h2><i class="fas fa-users-cog mr-2" style="color:#be185d;"></i> User Management</h2>

                <p>Navigate to <strong>System → Users Management</strong> to create and manage user accounts.</p>

                <h3>Creating a User</h3>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <h5>Basic Information</h5>
                        <p>Enter name, email, phone, NRC number, MAN number, and set a password. Assign one or more <strong>roles</strong>.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <h5>Employment Details</h5>
                        <p>Set the employee's position, department (dropdown), supervisor (dropdown), employee ID, date of birth, gender, date joined, and contract type.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <h5>Emergency Contact</h5>
                        <p>Enter emergency contact name, phone number, and the employee's physical address.</p>
                    </div>
                </div>

                <h3>Editing a User</h3>
                <p>Click on a user's name in the list to view and edit their full profile. You can also change their role assignments here.</p>

                <h3>User Fields Reference</h3>
                <table class="perm-table">
                    <thead><tr><th>Field</th><th>Description</th><th>Required</th></tr></thead>
                    <tbody>
                        <tr><td>Name</td><td>Full name</td><td>Yes</td></tr>
                        <tr><td>Email</td><td>Login email (must be unique)</td><td>Yes</td></tr>
                        <tr><td>Phone</td><td>Mobile number</td><td>No</td></tr>
                        <tr><td>NRC Number</td><td>National Registration Card</td><td>No</td></tr>
                        <tr><td>MAN Number</td><td>BiLTA MAN number</td><td>No</td></tr>
                        <tr><td>Employee ID</td><td>Internal employee reference</td><td>No</td></tr>
                        <tr><td>Position</td><td>Job title</td><td>No</td></tr>
                        <tr><td>Department</td><td>Linked to Departments table</td><td>No</td></tr>
                        <tr><td>Supervisor</td><td>Direct reporting manager</td><td>No</td></tr>
                        <tr><td>Role(s)</td><td>Determines permissions</td><td>Yes</td></tr>
                    </tbody>
                </table>

                {{-- ============================== ROLES & PERMISSIONS ============================== --}}
                @elseif ($activeSection === 'roles-permissions')
                <h2><i class="fas fa-shield-alt mr-2" style="color:#cd5b13;"></i> Roles & Permissions</h2>

                <p>The system uses Role-Based Access Control (RBAC). Each user is assigned one or more roles, and each role has a set of permissions that control what the user can see and do.</p>

                <h3>Default Roles</h3>
                <table class="perm-table">
                    <thead><tr><th>Role</th><th>Access Level</th><th>Typical Users</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Administrator</strong></td><td>Full access to everything</td><td>IT Admin, Executive Director</td></tr>
                        <tr><td><strong>Content Manager</strong></td><td>All content + leave + departments (30 permissions)</td><td>HR Manager, Communications Lead</td></tr>
                        <tr><td><strong>Editor</strong></td><td>Edit content only (16 permissions)</td><td>Content writers, project officers</td></tr>
                        <tr><td><strong>Viewer</strong></td><td>Read-only dashboard + analytics (5 permissions)</td><td>General staff, visitors with accounts</td></tr>
                    </tbody>
                </table>

                <h3>How Permissions Work</h3>
                <ul>
                    <li>Each menu item in the sidebar is protected by a permission (e.g., "manage-news").</li>
                    <li>If your role does not include a permission, you <strong>will not see</strong> the menu item and <strong>cannot access</strong> the page.</li>
                    <li>Administrators can customise which permissions belong to each role.</li>
                </ul>

                <h3>Managing Roles</h3>
                <ol>
                    <li>Go to <strong>System → Roles</strong>.</li>
                    <li>Click on a role to view/edit its permissions.</li>
                    <li>Check or uncheck permissions, then save.</li>
                </ol>

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
                    <div><strong>Note:</strong> Admin panel pages are NOT tracked — analytics only captures public website visits. Bot traffic is automatically excluded.</div>
                </div>

                {{-- ============================== FAQ ============================== --}}
                @elseif ($activeSection === 'faq')
                <h2><i class="fas fa-question-circle mr-2" style="color:#64748b;"></i> FAQ & Troubleshooting</h2>

                <h3>Frequently Asked Questions</h3>

                <h4>Q: I can't see certain menu items in the sidebar.</h4>
                <p><strong>A:</strong> Your role doesn't include the required permission. Ask your administrator to assign the needed permissions to your role, or assign you a different role.</p>

                <h4>Q: My leave balance shows 0 days remaining.</h4>
                <p><strong>A:</strong> Either your balance hasn't been allocated for this year, or all days have been used. Ask your HR administrator to check your balance in <strong>Leave Management → Leave Balances</strong>.</p>

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
                <p><strong>A:</strong> Use the "Forgot Password?" link on the login page, or ask your administrator to reset your password from the Users Management section.</p>

                <div class="tip-box tip-info">
                    <i class="fas fa-headset"></i>
                    <div><strong>Still need help?</strong> Contact your system administrator or the IT department for further assistance.</div>
                </div>

                @endif

            </div>
        </div>
    </div>
</div>
