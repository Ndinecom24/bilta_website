<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed role-permission assignments from config/chilolezo.php
     */
    public function run()
    {
        $rolePermissions = config('chilolezo.role_permissions', []);
        $allPermissionIds = Permission::pluck('id', 'slug');

        foreach ($rolePermissions as $roleSlug => $permissionSlugs) {
            $role = Role::where('slug', $roleSlug)->first();

            if (! $role) {
                $this->command->warn("Role '{$roleSlug}' not found — skipping.");
                continue;
            }

            // '*' means all permissions
            if ($permissionSlugs === '*') {
                $role->permissions()->syncWithoutDetaching($allPermissionIds->values()->toArray());
                $this->command->info("Role '{$role->name}' → ALL permissions assigned.");
                continue;
            }

            $ids = $allPermissionIds->only($permissionSlugs)->values()->toArray();

            if (empty($ids)) {
                $this->command->warn("No matching permissions found for role '{$role->name}'.");
                continue;
            }

            $role->permissions()->syncWithoutDetaching($ids);
            $this->command->info("Role '{$role->name}' → " . count($ids) . ' permissions assigned.');
        }
    }
}
