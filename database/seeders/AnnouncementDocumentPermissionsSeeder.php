<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementDocumentPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Create permissions
        $permissions = [
            ['name' => 'Manage Announcements', 'slug' => 'manage-announcements'],
            ['name' => 'Manage Documents', 'slug' => 'manage-documents'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $permission['slug']],
                ['name' => $permission['name'], 'slug' => $permission['slug']]
            );
        }

        $this->command->info('Permissions created: manage-announcements, manage-documents');

        // 2. Assign to roles: admin, content-manager, editor
        $roleSlugs = ['admin', 'content-manager', 'editor'];
        $permissionIds = DB::table('permissions')
            ->whereIn('slug', ['manage-announcements', 'manage-documents'])
            ->pluck('id');

        foreach ($roleSlugs as $roleSlug) {
            $roleId = DB::table('roles')->where('slug', $roleSlug)->value('id');

            if (!$roleId) {
                $this->command->warn("Role '{$roleSlug}' not found — skipping.");
                continue;
            }

            foreach ($permissionIds as $permId) {
                DB::table('roles_permissions')->updateOrInsert(
                    ['role_id' => $roleId, 'permission_id' => $permId],
                    ['role_id' => $roleId, 'permission_id' => $permId]
                );
            }

            $this->command->info("Assigned manage-announcements + manage-documents to '{$roleSlug}'.");
        }
    }
}
