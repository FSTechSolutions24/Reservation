<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:view_city')->only(['index', 'show']);
        $this->middleware('permission:create_city')->only('store');
        $this->middleware('permission:edit_city')->only('update');
        $this->middleware('permission:delete_city')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('translation')->get();
        return response()->json($cities, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|unique:city_translations,name',
            'locale' => 'required|string',
        ]);

        $city = City::create();
        $city->translations()->create([
            'city_id'=>$city->id,
            'locale'=>$request->locale,
            'name'=>$request->name
        ]);

        $city->load('translations');

        return response()->json($city, 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {        
        $city = City::with('translation')->findOrFail($id);
        return response()->json($city, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city) {

        $validated = $request->validate([
            'name' => ['required', Rule::unique('city_translations', 'name')->ignore($city->id, 'city_id')],
            'locale' => 'required|string',
        ]);        
       
        $city->translations()->updateOrCreate([
            'locale'=>$validated['locale'],            
        ],[
            'name'=>$validated['name']
        ]);

        $city->load('translations');

        return response()->json($city, 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(City $city)
    {
        $city->delete();
        return response()->noContent();
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
