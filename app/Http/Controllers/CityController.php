<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends BaseCrudController
{
    protected string $model = City::class;
    protected ?string $translationRelation = 'translations';
    protected array $mainFields = [];
    protected array $translationFields = ['name', 'locale'];

    public function __construct()
    {
        $this->middleware('permission:view_city')->only(['index', 'show']);
        $this->middleware('permission:create_city')->only('store');
        $this->middleware('permission:edit_city')->only('update');
        $this->middleware('permission:delete_city')->only('destroy');
    }

    protected function validationRules(Request $request, $id = null): array
    {

        $nameRule = Rule::unique('city_translations', 'name');

        if (!is_null($id)) {
            $nameRule->ignore($id, 'city_id');
        }

        return [
            'name' => ['required', $nameRule],
            'locale' => 'required|string',
        ];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|string',
            'translations.*.name' => 'required|string|distinct', // distinct = no duplicate names in array
        ]);

        $city = City::create(); // Create the empty city

        // Prepare translations
        $translationsData = [];
        foreach ($validated['translations'] as $translation) {
            $translationsData[] = [
                'city_id' => $city->id,
                'locale' => $translation['locale'],
                'name' => $translation['name'],
            ];
        }

        // Save all translations at once
        $city->translations()->createMany($translationsData);

        $city->load('translations'); // Eager load translations

        return response()->json($city, 201);
    }
}
