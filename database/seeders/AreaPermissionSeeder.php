<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class AreaPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['create_area', 'edit_area', 'delete_area', 'view_area'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
    }
}
