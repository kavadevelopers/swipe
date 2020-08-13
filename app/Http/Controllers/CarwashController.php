<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carwash;
use App\Package;
use App\Brand;
use App\Carmodel;
use Input;

class CarwashController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $car_wash = Package::all();
        return view('admin.car_wash', compact('car_wash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brands = Brand::all();
        return view('admin.add_car_wash',compact('brands'));
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
            'package_name' => 'required',            
            'package_category' => 'required',            
            'package_type' => 'required',            
            'package_price' => 'required'

        ]);
        $car_wash = new Package;
        $car_wash->package_name          = $request->package_name;
        $car_wash->package_category          = $request->package_category;
        $car_wash->package_type          = $request->package_type;
        $car_wash->package_price          = $request->package_price;
        $car_wash->package_desc   = $request->package_desc;
        
        $car_wash->save();

        return redirect()->Route('car_wash.index')->with('message', "Data Successfully Inserted");
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
        $brands = Brand::all();
        $car_wash = Package::where('id', $id)->first();
        $model_id = $car_wash->model_id;
        $model = Carmodel::where('id',$model_id)->get();
        return view('admin.add_car_wash', compact('car_wash','brands','model'));
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
        $car_wash = Package::find($id);
        // if (Input::hasfile('package_img')) {
        //    $file=Input::file('package_img');
        //    $file->move(public_path(). '/images/carwash', $file->getClientOriginalName());
        //    $car_wash->package_img=$file->getClientOriginalName();
        // }
        // $car_wash->package_name          = $request->package_name;

        // $car_wash->brand_id          = $request->brand_id;
        // if(is_null($request->car_model)){
        //     $car_wash->model_id          = $request->model_id;
        // }else{
        //     $car_wash->model_id          = $request->car_model;
        // }
        // $car_wash->package_category          = $request->package_category;
        // $car_wash->package_type          = $request->package_type;
        // $car_wash->package_price          = $request->package_price;
        // $car_wash->package_desc   = $request->package_desc;
        
        $car_wash->package_name          = $request->package_name;
        $car_wash->package_category          = $request->package_category;
        $car_wash->package_type          = $request->package_type;
        $car_wash->package_price          = $request->package_price;
        $car_wash->package_desc   = $request->package_desc;
        $car_wash->update();

        return redirect()->Route('car_wash.index')->with('message', "Data Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_wash = Package::find($id);
        $car_wash->delete();
        return redirect()->Route('car_wash.index')->with('message', "Data Successfully Deleted");
    }
}
