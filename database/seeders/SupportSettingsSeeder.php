<?php

namespace Database\Seeders;

use App\Models\Support\TicketBillingRate;
use Illuminate\Database\Seeder;

class SupportSettingsSeeder extends Seeder
{
    /**
     * Seed everything on Support > Settings:
     *  - Categories, Systems/Modules and Priorities (via SupportLookupSeeder)
     *  - The default (all developers) billing rate
     *
     * Safe to re-run: nothing that already exists is overwritten, so edits
     * made on the settings page are preserved.
     */
    public function run()
    {
        $this->call(SupportLookupSeeder::class);

        // A default rate has developer_id = null. Only create one if none exists,
        // otherwise a re-run would add duplicates or undo changes made in the UI.
        $hasDefault = TicketBillingRate::whereNull('developer_id')->exists();

        if (! $hasDefault) {
            TicketBillingRate::create([
                'name' => 'Standard Development Rate',
                'hourly_rate' => config('support.default_hourly_rate'),
                'currency' => strtoupper(config('support.currency')),
                'developer_id' => null,
                'effective_from' => now()->startOfYear()->toDateString(),
                'effective_to' => null,
                'is_active' => true,
            ]);

            $this->command->info('Default billing rate created.');
        } else {
            $this->command->info('Default billing rate already exists - skipped.');
        }

        $this->command->info('Support settings seeded.');
    }
}
