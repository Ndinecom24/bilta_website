<?php

namespace Database\Seeders;

use App\Models\Bilta\Department;
use App\Models\Bilta\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'name' => 'Executive Director',
                'code' => 'ED',
                'dept_code' => 'EXEC',
                'description' => 'Chief executive officer responsible for overall leadership and strategic governance of BILTA.',
            ],
            [
                'name' => 'Programs Manager',
                'code' => 'PM',
                'dept_code' => 'PROG',
                'description' => 'Leads and coordinates all program activities, strategic projects, and field implementation.',
            ],
            [
                'name' => 'Translation Consultant',
                'code' => 'TC',
                'dept_code' => 'TRANS',
                'description' => 'Provides linguistic, exegetical, and translation consulting to language teams.',
            ],
            [
                'name' => 'Senior Translator',
                'code' => 'STRANS',
                'dept_code' => 'TRANS',
                'description' => 'Leads mother-tongue translation teams and quality reviews.',
            ],
            [
                'name' => 'Translator',
                'code' => 'TRANS',
                'dept_code' => 'TRANS',
                'description' => 'Translates Scripture and educational literature into target languages.',
            ],
            [
                'name' => 'Literacy Specialist',
                'code' => 'LIT-SPEC',
                'dept_code' => 'LIT',
                'description' => 'Designs literacy curriculum, mother-tongue primers, and teacher training programs.',
            ],
            [
                'name' => 'Literacy Officer',
                'code' => 'LIT-OFF',
                'dept_code' => 'LIT',
                'description' => 'Conducts community literacy classes, workshops, and learner assessments.',
            ],
            [
                'name' => 'Scripture Engagement Coordinator',
                'code' => 'SE-COORD',
                'dept_code' => 'SE',
                'description' => 'Coordinates community Scripture engagement, listening groups, and digital scripture distribution.',
            ],
            [
                'name' => 'Human Resources Manager',
                'code' => 'HR-MGR',
                'dept_code' => 'HR',
                'description' => 'Manages human resource operations, staff development, employee welfare, and compliance.',
            ],
            [
                'name' => 'Human Resources Officer',
                'code' => 'HR-OFF',
                'dept_code' => 'HR',
                'description' => 'Assists with staff onboarding, leave tracking, records management, and personnel files.',
            ],
            [
                'name' => 'Finance Manager / Senior Accountant',
                'code' => 'FIN-MGR',
                'dept_code' => 'FIN',
                'description' => 'Directs financial reporting, budgets, cash flow management, audits, and donor compliance.',
            ],
            [
                'name' => 'Accountant',
                'code' => 'ACC',
                'dept_code' => 'FIN',
                'description' => 'Handles day-to-day accounting, payables, receivables, and statutory returns.',
            ],
            [
                'name' => 'IT Specialist',
                'code' => 'IT-SPEC',
                'dept_code' => 'IT',
                'description' => 'Oversees computer networks, database servers, web portals, and tech support.',
            ],
            [
                'name' => 'Systems Administrator',
                'code' => 'SYS-ADMIN',
                'dept_code' => 'IT',
                'description' => 'Maintains operating infrastructure, cloud systems, backups, and cybersecurity.',
            ],
            [
                'name' => 'Communications Officer',
                'code' => 'COMM-OFF',
                'dept_code' => 'COMM',
                'description' => 'Coordinates organization newsletters, social media, photography, and press releases.',
            ],
            [
                'name' => 'Company Secretary',
                'code' => 'SEC',
                'dept_code' => 'EXEC',
                'description' => 'Oversees corporate governance, Board records, legal filings, and institutional compliance.',
            ],
            [
                'name' => 'Administrative Assistant',
                'code' => 'ADMIN-ASST',
                'dept_code' => 'ADMIN',
                'description' => 'Assists with office administration, front desk, travel logistics, and procurement.',
            ],
            [
                'name' => 'Office Assistant',
                'code' => 'OA',
                'dept_code' => 'ADMIN',
                'description' => 'Provides office support services, inventory maintenance, and logistical support.',
            ],
        ];

        // Cache departments by code and name
        $deptMap = Department::pluck('id', 'code');
        $deptNameMap = Department::pluck('id', 'name');

        foreach ($positions as $item) {
            $departmentId = $deptMap[$item['dept_code']] ?? $deptNameMap[$item['dept_code']] ?? null;

            Position::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'description' => $item['description'],
                    'department_id' => $departmentId,
                    'status_id' => 1,
                ]
            );
        }

        // Also create any positions that exist on users but not yet in the positions table
        $existingUserPositions = User::whereNotNull('position')
            ->where('position', '!=', '')
            ->pluck('position')
            ->unique();

        foreach ($existingUserPositions as $posName) {
            $trimmed = trim($posName);
            if (empty($trimmed)) {
                continue;
            }
            $slug = Str::slug($trimmed);
            if (! Position::where('slug', $slug)->exists()) {
                Position::create([
                    'name' => $trimmed,
                    'slug' => $slug,
                    'code' => strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $trimmed), 0, 8)),
                    'status_id' => 1,
                ]);
            }
        }

        // Map users to their respective position_id
        $allPositions = Position::all();
        foreach ($allPositions as $pos) {
            User::whereNull('position_id')
                ->where(function ($q) use ($pos) {
                    $q->where('position', $pos->name)
                      ->orWhere('position', $pos->slug);
                })
                ->update(['position_id' => $pos->id]);

            if (Schema::hasTable('user_department_responsibilities')) {
                DB::table('user_department_responsibilities')
                    ->whereNull('position_id')
                    ->where(function ($q) use ($pos) {
                        $q->where('position', $pos->name)
                          ->orWhere('position', $pos->slug);
                    })
                    ->update(['position_id' => $pos->id]);
            }
        }

        $this->command->info('Positions seeded: ' . Position::count());
    }
}
