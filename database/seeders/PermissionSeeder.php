<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed permissions from config/chilolezo.php
     */
    public function run()
    {
        $permissions = config('chilolezo.permissions', []);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }

        $this->command->info('Permissions seeded: ' . count($permissions));
    }
}
