<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class CityPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['create_city', 'edit_city', 'delete_city', 'view_city'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
    }
}
