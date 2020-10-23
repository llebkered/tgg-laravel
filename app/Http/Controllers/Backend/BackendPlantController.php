<?php

namespace App\Http\Controllers\Backend;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlantCategory;

class BackendPlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = Plant::all();

        return view('backend.plant.index', compact(['plants']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plant_categories = PlantCategory::where('published', '=', '1')->get();
        $plant = new Plant;

        return view('backend.plant.create', compact('plant', 'plant_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plant = $request->validate([
            'title' => 'required',
            'botanical_name' => 'required',
            'description' => 'required'
        ]);

        Plant::create($plant);

        return redirect()->route('backend.plants.index')
            ->with('success_message', 'Plant has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        $plant_categories = PlantCategory::where('published', '=', '1')->get();

        return view('backend.plant.edit', compact('plant', 'plant_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Plant $plant)
    {
        $plant_categories = PlantCategory::where('published', '=', '1')->get();

        return view('backend.plant.edit', compact('plant', 'plant_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $plant = Plant::find($id);
        $plant_categories = PlantCategory::where('published', '=', '1')->get();

        $data = $request->validate([
            'title' => 'required',
            'botanical_name' => 'required',
            'description' => 'required'
        ]);

        $plant->update($data);

        return view('backend.plant.edit', compact('plant', 'plant_categories'))->with('success_message', 'Plant has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Plant::destroy($id);
        return redirect()->route('backend.plants.index')->with('success_message', 'Plant has been deleted.');
    }
}
