<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SqlDumpSeeder::class,
            SiteContentSeeder::class,
            AdminAndDemoSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            LeaveManagementRolesSeeder::class,
            AnnouncementDocumentPermissionsSeeder::class,
            DepartmentSeeder::class,
            LeaveTypeSeeder::class,
        ]);
    }
}
