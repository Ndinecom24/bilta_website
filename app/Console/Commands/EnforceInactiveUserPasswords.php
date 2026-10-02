<?php

namespace App\Console\Commands;

use App\Services\UserPasswordEnforcement;
use Illuminate\Console\Command;

class EnforceInactiveUserPasswords extends Command
{
    protected $signature = 'users:enforce-password-resets';

    protected $description = 'Remind users with pending password changes and require resets for 90-day inactive accounts';

    public function handle(UserPasswordEnforcement $enforcement)
    {
        $reminders = $enforcement->sendPendingPasswordReminders();
        $resets = $enforcement->forceResetInactiveUsers();

        $this->info("Pending password reminders sent: {$reminders['sent']}; failed: {$reminders['failed']}.");
        $this->info("Inactive account resets sent: {$resets['sent']}; failed: {$resets['failed']}.");

        return $reminders['failed'] || $resets['failed'] ? 1 : 0;
    }
}