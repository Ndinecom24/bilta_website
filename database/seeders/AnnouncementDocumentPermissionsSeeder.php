<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementDocumentPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'manage-announcements', 'slug' => 'manage-announcements'],
            ['name' => 'manage-documents', 'slug' => 'manage-documents'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $permission['slug']],
                ['name' => $permission['name'], 'slug' => $permission['slug']]
            );
        }

        // Assign to admin role (id = 1 typically)
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');

        if ($adminRoleId) {
            $permissionIds = DB::table('permissions')
                ->whereIn('slug', ['manage-announcements', 'manage-documents'])
                ->pluck('id');

            foreach ($permissionIds as $permId) {
                DB::table('roles_permissions')->updateOrInsert(
                    ['role_id' => $adminRoleId, 'permission_id' => $permId],
                    ['role_id' => $adminRoleId, 'permission_id' => $permId]
                );
            }
        }
    }
}
