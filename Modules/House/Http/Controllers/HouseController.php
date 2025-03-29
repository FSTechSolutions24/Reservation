<?php

namespace Modules\House\Http\Controllers;

use Illuminate\Http\Request;
use Modules\House\Entities\House;
use App\Http\Controllers\Controller;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('house::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('house::create');
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
        $house = House::where('id', $id)->firstOrFail();
        return response()->json($house, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('house::edit');
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
