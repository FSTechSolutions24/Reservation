<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Routing\Controller;

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
    public function store(Request $request) {}

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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
