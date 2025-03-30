<?php

namespace Modules\House\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\House\Entities\House;
use Modules\House\Entities\HouseTranslation;

class HouseSeeder extends Seeder
{
    public function run()
    {
        House::factory()->count(10)->create();
        HouseTranslation::factory()->count(10)->create();
    }
}
