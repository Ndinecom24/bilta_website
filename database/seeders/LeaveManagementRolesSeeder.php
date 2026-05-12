<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Database\Seeder;

class LeaveManagementRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'leave-applicant' => [
                'name' => 'Leave Applicant',
                'permissions' => ['view-dashboard', 'apply-leave'],
            ],
            'leave-approver' => [
                'name' => 'Leave Approver',
                'permissions' => ['view-dashboard', 'apply-leave'],
            ],
            'leave-officer' => [
                'name' => 'Leave Officer',
                'permissions' => [
                    'view-dashboard',
                    'manage-leave-types',
                    'manage-leave-applications',
                    'apply-leave',
                    'manage-leave-balances',
                ],
            ],
            'leave-workflow-manager' => [
                'name' => 'Leave Workflow Manager',
                'permissions' => ['view-dashboard', 'manage-approval-workflows', 'apply-leave'],
            ],
            'leave-manager' => [
                'name' => 'Leave Manager',
                'permissions' => [
                    'view-dashboard',
                    'manage-leave-types',
                    'manage-leave-applications',
                    'apply-leave',
                    'manage-leave-balances',
                    'manage-approval-workflows',
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $data['name']]
            );

            $permissionIds = Permission::whereIn('slug', $data['permissions'])->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);

            $this->command->info("Leave role seeded: {$role->name} (" . count($permissionIds) . ' permissions)');
        }
    }
}
