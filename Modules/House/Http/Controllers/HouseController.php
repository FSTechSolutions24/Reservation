<?php

namespace Modules\House\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\House\Entities\House;
use App\Http\Controllers\BaseCrudController;

class HouseController extends BaseCrudController
{
    protected string $model = House::class;
    protected ?string $translationRelation = 'translations';
    protected array $mainFields = ['gps_location', 'city_id', 'area_id', 'capacity'];
    protected array $translationFields = ['name', 'locale', 'address', 'description', 'policy'];

    protected function validationRules(Request $request, $id = null): array
    {

        $nameRule = Rule::unique('house_translations', 'name');
        $gpsUniqueRule = Rule::unique('houses', 'gps_location');

        if (!is_null($id)) {
            $nameRule->ignore($id, 'house_id');
            $gpsUniqueRule->ignore($id, 'id');
        }

        $gpsRule = [
            'required',
            'regex:/^-?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*-?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
            $gpsUniqueRule
        ];

        return [
            'name' => ['required', $nameRule],
            'locale' => 'required|string',
            'gps_location' => $gpsRule,
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'exists:areas,id',
            'capacity' => 'nullable|integer',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'policy' => 'nullable|string',
        ];

    }
    
}
