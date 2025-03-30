<?php

namespace Modules\House\Database\Factories;

use Modules\House\Entities\House;
use Modules\House\Entities\HouseTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseTranslationFactory extends Factory
{
    protected $model = HouseTranslation::class;

    public function definition()
    {
        return [
            'house_id' => function () {
                return House::inRandomOrder()->first()->id;
            },
            'locale' => function (array $attributes) {
                // Ensure the house_id exists
                if (!isset($attributes['house_id'])) {
                    return null;
                }
        
                // Get already used locales for the selected house
                $usedLocales = \Modules\House\Entities\HouseTranslation::where('house_id', $attributes['house_id'])
                    ->pluck('locale')
                    ->toArray();
        
                // Get available locales
                $availableLocales = array_diff(['en', 'ar'], $usedLocales);
        
                // If no available locale, return null to prevent duplicate entry
                return !empty($availableLocales) ? fake()->randomElement($availableLocales) : null;
            },
            'name' => fake()->words(4, true),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'policy' => fake()->text(300),
        ];
        
    }
}

