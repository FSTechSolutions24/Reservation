<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends BaseCrudController
{
    protected string $model = Area::class;
    protected ?string $translationRelation = 'translations';
    protected array $mainFields = ['city_id'];
    protected array $translationFields = ['name', 'locale'];

    public function __construct()
    {
        $this->middleware('permission:view_area')->only(['index', 'show']);
        $this->middleware('permission:create_area')->only('store');
        $this->middleware('permission:edit_area')->only('update');
        $this->middleware('permission:delete_area')->only('destroy');
    }

    protected function validationRules(Request $request, $id = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($id, $request) {
                    $cityId = $request->input('city_id');
                    $exists = DB::table('area_translations')
                        ->join('areas', 'areas.id', '=', 'area_translations.area_id')
                        ->where('area_translations.name', $value)
                        ->where('areas.city_id', $cityId)
                        ->when($id, function ($q) use ($id) {
                            $q->where('area_translations.area_id', '!=', $id);
                        })
                        ->exists();
                    if ($exists) {
                        $fail("The name has already been taken for this city.");
                    }
                }
            ],
            'locale'    =>  'required|string|size:2',
            'city_id'   =>  'required|exists:cities,id',
        ];
    }
}

