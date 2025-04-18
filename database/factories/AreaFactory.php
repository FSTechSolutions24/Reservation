<?php

namespace Database\Factories;
use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition()
    {
        return [
            'city_id' => City::inRandomOrder()->first()->id,
        ];
    }
}
