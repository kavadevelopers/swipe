<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use Input;

class VehicleAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicletypelist', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_vehicle_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle_type' => 'required|unique:vehicles',
            'description' => 'required',
            'icon' => 'required',
            'rate' => 'required'            
        ]);
        $vehicle = new Vehicle;
        if (Input::hasfile('icon')) {
           $file=Input::file('icon');
           $file->move(public_path(). '/img', $file->getClientOriginalName());
           $vehicle->icon=$file->getClientOriginalName();
        }
        $vehicle->vehicle_type      = $request->vehicle_type;
        $vehicle->status          = '1';
        $vehicle->description          = $request->description;
        $vehicle->rate      = $request->rate;
        
        $vehicle->save();

        return redirect()->Route('vehicle_types.index')->with('message', "Data Successfully Inserted");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $vehicles = Vehicle::where('id', $id)->first();
        return view('admin.add_vehicle_type', compact('vehicles'));
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
        $validatedData = $request->validate([
            'vehicle_type' => 'required',
            'description' => 'required',
            'icon' => 'required',
            'rate' => 'required'
        ]);
        $vehicle = Vehicle::find($id);
        if (Input::hasfile('icon')) {
           $file=Input::file('icon');
           $file->move(public_path(). '/img', $file->getClientOriginalName());
           $vehicle->icon=$file->getClientOriginalName();
        }

        $vehicle->vehicle_type      = $request->vehicle_type;
        $vehicle->description          = $request->description;
        $vehicle->status          = '1';
        $vehicle->rate      = $request->rate;
        $vehicle->update();

        return redirect()->Route('vehicle_types.index')->with('message', "Data Successfully Updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect()->Route('vehicle_types.index')->with('message', "Data Successfully Deleted");
        
    }
}
