<?php

namespace App\Http\Controllers;

use App\VehicleColor;
use Illuminate\Http\Request;

use Config;
use Validator;

use Yajra\Datatables\Datatables;

class VehicleColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vehicle_color.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $getdata =  VehicleColor::get();
        return Datatables::of($getdata)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle_color.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
        ]);
        $dataArr = array(
            'name'          => $input['name'],
            'code'            => $input['code'],
        );
        // if($validatedData->fails()){
        //     return redirect('/admin/vehicle_color/create')->withErrors($validatedData)->withInput();
        // }
        $vehicle_color = VehicleColor::create($dataArr);

        return redirect('/admin/vehicle_color')->with("success", "Vehicle Color added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleColor  $vehicleColor
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleColor $vehicleColor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleColor  $vehicleColor
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleColor $vehicleColor)
    {
        // $form = VehicleColor::where('id',$id)->first()->toArray();
        // if(empty($form)){
        //     return redirect('/admin/vehicle_color')->with("error", "Vehicle Color not found.");
        // }
        // $dataArr = array('id' => $id);
        // $dataArr['question']    = $form['question'];
        // $dataArr['answer']      = $form['answer'];
        return view('admin.vehicle_color.edit')->with('form', (object)$vehicleColor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleColor  $vehicleColor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleColor $vehicleColor)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
        ]);
        $input = $request->all();
        $dataArr = array(
            'name'          => $input['name'],
            'code'            => $input['code'],
        );
        $vehicleColor->update($dataArr);
        return redirect('/admin/vehicle_color')->with("success", "Vehicle Color updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleColor  $vehicleColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleColor $vehicleColor)
    {
        $vehicleColor->delete();
        return response()->json(["message" => 'Vehicle Color deleted!'], 200);
    }
}
