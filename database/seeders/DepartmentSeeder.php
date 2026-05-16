<?php

namespace Database\Seeders;

use App\Models\Bilta\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'Administration',
                'code' => 'ADMIN',
                'description' => 'General administration, HR, finance, and office management.',
            ],
            [
                'name' => 'Translation',
                'code' => 'TRANS',
                'description' => 'Bible and literature translation programs across language groups.',
            ],
            [
                'name' => 'Literacy & Education',
                'code' => 'LIT',
                'description' => 'Literacy programs, community education, and training.',
            ],
            [
                'name' => 'Scripture Engagement',
                'code' => 'SE',
                'description' => 'Scripture use promotion, community engagement, and distribution.',
            ],
            [
                'name' => 'Finance & Accounts',
                'code' => 'FIN',
                'description' => 'Financial management, accounting, budgeting, and auditing.',
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'IT infrastructure, systems support, and software development.',
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Staff welfare, recruitment, leave management, and HR policy.',
            ],
            [
                'name' => 'Programs & Projects',
                'code' => 'PROG',
                'description' => 'Program coordination, project management, and M&E.',
            ],
            [
                'name' => 'Communications & Media',
                'code' => 'COMM',
                'description' => 'Public relations, media production, and communication.',
            ],
            [
                'name' => 'Executive Management',
                'code' => 'EXEC',
                'description' => 'Executive Director office and senior leadership.',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['slug' => Str::slug($dept['name'])],
                array_merge($dept, [
                    'slug' => Str::slug($dept['name']),
                    'status_id' => 1,
                ])
            );
        }

        $this->command->info('Departments seeded: ' . count($departments));
    }
}
