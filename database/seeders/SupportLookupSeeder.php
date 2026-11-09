<?php

namespace Database\Seeders;

use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SupportLookupSeeder extends Seeder
{
    /**
     * Seed support ticket categories, priorities and system/modules.
     * Safe to re-run: existing rows are matched by slug and left editable.
     */
    public function run()
    {
        $categories = [
            ['Bug / Error', 'bug-error'],
            ['Technical Support', 'technical-support'],
            ['Feature Request', 'feature-request'],
            ['Enhancement', 'enhancement'],
            ['Change Request', 'change-request'],
            ['General Enquiry', 'general-enquiry'],
        ];
        foreach ($categories as $i => [$name, $slug]) {
            TicketCategory::firstOrCreate(['slug' => $slug], ['name' => $name, 'sort_order' => $i + 1]);
        }

        // slug => [name, level, target hours, colour]
        $priorities = [
            'low' => ['Low', 1, 168, 'success'],
            'medium' => ['Medium', 2, 72, 'info'],
            'high' => ['High', 3, 24, 'warning'],
            'critical' => ['Critical', 4, 8, 'danger'],
        ];
        foreach ($priorities as $slug => [$name, $level, $hours, $color]) {
            TicketPriority::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'level' => $level, 'resolution_target_hours' => $hours, 'color' => $color]
            );
        }

        $systems = [
            'Public Website', 'Admin Dashboard', 'Users & Roles', 'Leave Management',
            'Documents', 'Announcements', 'Departments, Positions & Branches',
            'Newsletters & Emails', 'Analytics', 'Other',
        ];
        foreach ($systems as $i => $name) {
            TicketSystem::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'sort_order' => $i + 1]);
        }

        $this->command->info('Support lookups seeded.');
    }
}
