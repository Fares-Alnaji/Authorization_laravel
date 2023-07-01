<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class , 'city');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cities = City::all();
        return response()->view('cms.cities.index' , compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name_en' => 'required|string|min:3|max:100',
            'name_ar' => 'required|string|min:3|max:100',
            'active' => 'nullable|string|in:on',
        ],[
            'name_en.min' => 'Please, city name must be at least 3 characters',
            'name_en.required' => 'You must enter a city name!',
            'name_ar.min' => 'Please, city name must be at least 3 characters',
            'name_ar.required' => 'You must enter a city name!',
        ]);
        //
        $city = new City();
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has('active');
        $isSaved = $city->save();
        if($isSaved){
            session()->flash('message', 'City created successfully');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
        return response()->view('cms.cities.edit' , compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validate = $request->validate([
            'name_en' => 'required|string|min:3|max:100',
            'name_ar' => 'required|string|min:3|max:100',
            'active' => 'nullable|string|in:on',
        ],[
            'name_en.min' => 'Please, city name must be at least 3 characters',
            'name_en.required' => 'You must enter a city name!',
            'name_ar.min' => 'Please, city name must be at least 3 characters',
            'name_ar.required' => 'You must enter a city name!',
        ]);

        //

        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has('active');
        $isSaved = $city->save();
        if($isSaved){
            session()->flash('message', 'City edit successfully');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
        $isDeleted = $city->delete();
        return redirect()->route('cities.index');
    }
}
