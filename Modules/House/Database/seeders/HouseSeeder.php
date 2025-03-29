<?php

namespace Modules\House\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\House\Entities\House;

class HouseSeeder extends Seeder
{
    public function run()
    {
        House::create([
            'name' => 'Luxury Villa',
            'address' => '123 Palm Street',
            'price' => 500000
        ]);

        House::create([
            'name' => 'Cozy Apartment',
            'address' => '456 Main Street',
            'price' => 150000
        ]);
    }
}
