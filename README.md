# bilta_website
this is the official website for bilta

## User password reminders and inactivity enforcement

The System Users page allows an administrator to send reminders to active accounts still marked as requiring a password change, and to review and confirm resets for accounts with no login activity for at least 90 days. Never-logged-in accounts are included after 90 days from creation. Administrator accounts are excluded from automatic inactivity resets.

The daily `users:enforce-password-resets` scheduled task sends pending-password reminders at most once every seven days and issues a 72-hour one-time password to eligible inactive accounts. The account must set a new password after signing in. Expired reset codes are rejected; users can request a standard password reset or contact an administrator.

For automatic processing in production, apply the database migrations and configure the Laravel scheduler to run every minute (`php artisan schedule:run`). Email delivery must also be configured. The same enforcement can be run manually with `php artisan users:enforce-password-resets`.
