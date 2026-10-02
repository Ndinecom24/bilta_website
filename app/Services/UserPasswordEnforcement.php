<?php

namespace App\Services;

use App\Mail\PasswordChangeReminderMail;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserPasswordEnforcement
{
    const REMINDER_COOLDOWN_DAYS = 7;
    const INACTIVE_DAYS = 90;
    const OTP_EXPIRY_HOURS = 72;

    /**
     * Remind active users who have not completed a required password change.
     */
    public function sendPendingPasswordReminders($ignoreCooldown = false)
    {
        $sent = 0;
        $failed = 0;
        $cutoff = now()->subDays(self::REMINDER_COOLDOWN_DAYS);

        User::where('status_id', config('constants.status.active'))
            ->where('password_change', 1)
            ->where(function ($query) use ($ignoreCooldown, $cutoff) {
                if ($ignoreCooldown) {
                    return;
                }

                $query->whereNull('password_reminder_sent_at')
                    ->orWhere('password_reminder_sent_at', '<=', $cutoff);
            })
            ->orderBy('id')
            ->chunkById(100, function ($users) use (&$sent, &$failed) {
                foreach ($users as $user) {
                    try {
                        Mail::to($user->email)->send(new PasswordChangeReminderMail($user));
                        $user->password_reminder_sent_at = now();
                        $user->save();
                        $sent++;
                    } catch (\Throwable $exception) {
                        report($exception);
                        $failed++;
                    }
                }
            });

        return compact('sent', 'failed');
    }

    /**
     * Issue a fresh temporary password and require an immediate password change
     * for active accounts with no login activity in the configured inactivity window.
     */
    public function forceResetInactiveUsers($ignoreCooldown = false)
    {
        $sent = 0;
        $failed = 0;
        $now = now();
        $inactiveBefore = $now->copy()->subDays(self::INACTIVE_DAYS);
        $eligibleCreatedBefore = $inactiveBefore->copy();
        $reminderCutoff = $now->copy()->subDays(self::REMINDER_COOLDOWN_DAYS);

        User::where('status_id', config('constants.status.active'))
            ->where(function ($query) {
                $query->where('password_change', '!=', 1)
                    ->orWhereNull('password_reset_otp')
                    ->orWhereNull('password_reset_otp_expires_at')
                    ->orWhere('password_reset_otp_expires_at', '<=', now());
            })
            ->where(function ($query) use ($inactiveBefore, $eligibleCreatedBefore) {
                $query->where('last_login', '<=', $inactiveBefore)
                    ->orWhere(function ($neverLoggedIn) use ($eligibleCreatedBefore) {
                        $neverLoggedIn->whereNull('last_login')
                            ->where('created_at', '<=', $eligibleCreatedBefore);
                    });
            })
            ->where(function ($query) use ($ignoreCooldown, $reminderCutoff) {
                if ($ignoreCooldown) {
                    return;
                }

                $query->whereNull('password_reminder_sent_at')
                    ->orWhere('password_reminder_sent_at', '<=', $reminderCutoff);
            })
            // Preserve at least one administrator's access; admins are handled manually.
            ->whereDoesntHave('roles', function ($query) {
                $query->where('slug', 'admin');
            })
            ->orderBy('id')
            ->chunkById(100, function ($users) use (&$sent, &$failed, $now) {
                foreach ($users as $user) {
                    $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
                    $oldPassword = $user->password;
                    $oldPasswordChange = $user->password_change;
                    $oldOtp = $user->password_reset_otp;
                    $oldOtpExpiry = $user->password_reset_otp_expires_at;
                    $oldReminderSentAt = $user->password_reminder_sent_at;

                    try {
                        $user->password = Hash::make($otp);
                        $user->password_change = 1;
                        $user->password_reset_otp = $otp;
                        $user->password_reset_otp_expires_at = $now->copy()->addHours(self::OTP_EXPIRY_HOURS);
                        $user->password_reminder_sent_at = $now;
                        $user->save();

                        Mail::to($user->email)->send(new PasswordResetOtpMail($user, $otp, 'BiLTA account security'));
                        $sent++;
                    } catch (\Throwable $exception) {
                        report($exception);
                        try {
                            $user->password = $oldPassword;
                            $user->password_change = $oldPasswordChange;
                            $user->password_reset_otp = $oldOtp;
                            $user->password_reset_otp_expires_at = $oldOtpExpiry;
                            $user->password_reminder_sent_at = $oldReminderSentAt;
                            $user->save();
                        } catch (\Throwable $restoreException) {
                            report($restoreException);
                        }
                        $failed++;
                    }
                }
            });

        return compact('sent', 'failed');
    }

    public function countPendingPasswordChanges()
    {
        return User::where('status_id', config('constants.status.active'))
            ->where('password_change', 1)
            ->count();
    }

    public function countInactiveUsersDueForReset()
    {
        $inactiveBefore = now()->subDays(self::INACTIVE_DAYS);

        return User::where('status_id', config('constants.status.active'))
            ->where(function ($query) use ($inactiveBefore) {
                $query->where('password_change', '!=', 1)
                    ->orWhereNull('password_reset_otp')
                    ->orWhereNull('password_reset_otp_expires_at')
                    ->orWhere('password_reset_otp_expires_at', '<=', now());
            })
            ->where(function ($query) use ($inactiveBefore) {
                $query->where('last_login', '<=', $inactiveBefore)
                    ->orWhere(function ($neverLoggedIn) use ($inactiveBefore) {
                        $neverLoggedIn->whereNull('last_login')
                            ->where('created_at', '<=', $inactiveBefore);
                    });
            })
            ->whereDoesntHave('roles', function ($query) {
                $query->where('slug', 'admin');
            })
            ->count();
    }
}
