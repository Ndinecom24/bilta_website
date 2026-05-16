<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeaveTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name' => 'Annual Leave',
                'slug' => 'annual-leave',
                'description' => 'Standard paid annual leave for all employees.',
                'default_days' => 24,
                'requires_document' => false,
                'is_paid' => true,
                'carry_over' => true,
                'max_carry_over_days' => 5,
                'status_id' => 1,
            ],
            [
                'name' => 'Sick Leave',
                'slug' => 'sick-leave',
                'description' => 'Leave for medical illness or injury. A medical certificate is required.',
                'default_days' => 26,
                'requires_document' => true,
                'is_paid' => true,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
            [
                'name' => 'Hospitalisation Leave',
                'slug' => 'hospitalisation-leave',
                'description' => 'Leave for hospital admission. Supporting medical documentation required.',
                'default_days' => 26,
                'requires_document' => true,
                'is_paid' => true,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
            [
                'name' => 'Maternity Leave',
                'slug' => 'maternity-leave',
                'description' => 'Paid maternity leave for expecting mothers.',
                'default_days' => 90,
                'requires_document' => true,
                'is_paid' => true,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
            [
                'name' => 'Study / Exam Leave',
                'slug' => 'study-exam-leave',
                'description' => 'Leave for educational purposes, exams, or professional development.',
                'default_days' => 10,
                'requires_document' => true,
                'is_paid' => true,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
            [
                'name' => 'Emergency Leave',
                'slug' => 'emergency-leave',
                'description' => 'Leave granted for urgent personal or family emergencies.',
                'default_days' => 5,
                'requires_document' => false,
                'is_paid' => true,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
            [
                'name' => 'Others',
                'slug' => 'others',
                'description' => 'Any other leave type not listed above. Specify in application.',
                'default_days' => 0,
                'requires_document' => false,
                'is_paid' => false,
                'carry_over' => false,
                'max_carry_over_days' => 0,
                'status_id' => 1,
            ],
        ];

        foreach ($types as $type) {
            if (!DB::table('leave_types')->where('slug', $type['slug'])->exists()) {
                DB::table('leave_types')->insert(array_merge($type, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        $this->command->info('Leave types seeded: ' . count($types));
    }
}
