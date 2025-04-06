<?php

namespace Database\Seeders;

use App\Models\Area;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\User;
use App\Models\AreaTranslation;
use App\Models\CityTranslation;
use Illuminate\Database\Seeder;
use Database\Seeders\CityPermissionSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // City::factory()->count(10)->create();
        // CityTranslation::factory()->count(10)->create();
        // Area::factory()->count(10)->create();
        // AreaTranslation::factory()->count(10)->create();
        $this->call(CityPermissionSeeder::class);
    }
}
