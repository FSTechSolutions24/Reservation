<?php

namespace Modules\House\Database\factories;

use App\Models\Area;
use App\Models\City;
use Modules\House\Entities\House;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
{
    protected $model = House::class;

    public function definition()
    {
        return [
            'city_id' => City::inRandomOrder()->first()->id,
            'area_id' => Area::inRandomOrder()->first()->id,
            'capacity' => fake()->numberBetween(40, 200), // Generates a number between 40 and 200
            'gps_location' => fake()->latitude() . ', ' . fake()->longitude(),
        ];
    }
}

