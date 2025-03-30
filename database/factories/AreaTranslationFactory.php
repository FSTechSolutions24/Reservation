<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AreaTranslation;
use App\Models\Area;

class AreaTranslationFactory extends Factory
{
    protected $model = AreaTranslation::class;

    public function definition()
    {
        return [
            'area_id' => Area::inRandomOrder()->first()->id,
            'locale' => fake()->randomElement(['en', 'ar']),
            'name' => fake()->city(),
        ];
    }
}

