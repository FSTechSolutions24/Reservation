<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CityTranslation;
use App\Models\City;

class CityTranslationFactory extends Factory
{
    protected $model = CityTranslation::class;

    public function definition()
    {
        return [
            'city_id' => City::inRandomOrder()->first()->id,
            'locale' => fake()->randomElement(['en', 'ar']),
            'name' => fake()->city(),
        ];
    }
}

