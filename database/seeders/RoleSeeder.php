<?php

namespace Database\Seeders;

use App\Models\System\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed roles from config/chilolezo.php
     */
    public function run()
    {
        $roles = config('chilolezo.roles', []);

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name']]
            );
        }

        $this->command->info('Roles seeded: ' . count($roles));
    }
}
