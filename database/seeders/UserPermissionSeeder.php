<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create_admin', 'edit_admin', 'delete_admin', 'view_admin',
            'create_user', 'edit_user', 'delete_user', 'view_user'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
    }
}
