<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Brand;
use Input;
use DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $cars = DB::table('cars')
            ->join('brands', 'cars.brand_id', '=', 'brands.id')
            ->join('carmodels', 'carmodels.brand_id', '=', 'brands.id')
            ->select('cars.id','cars.car_category','cars.brand_id','cars.car_desc','cars.car_img','cars.car_model','cars.status','cars.created_at','brands.brand_name','carmodels.model_name')
            ->get();
        return view('admin.cars', compact('cars'));
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
        return view('admin.add_car', compact('brands'));
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
            'car_category' => 'required',            
            'car_img' => 'required',            
            'brand_id' => 'required'            
        ]);
        $car = new Car;
        if (Input::hasfile('car_img')) {
           $file=Input::file('car_img');
           $file->move(public_path(). '/images/car', $file->getClientOriginalName());
           $car->car_img=$file->getClientOriginalName();
        }
        $car->car_category          = $request->car_category;
        $car->brand_id          = $request->brand_id;
        $car->car_model          = $request->car_model;
        $car->car_desc          = $request->car_desc;
        
        $car->save();

        return redirect()->Route('cars.index')->with('message', "Data Successfully Inserted");
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
        $cars = Car::where('id', $id)->first();
        return view('admin.add_car', compact('cars','brands'));
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
        $car = Car::find($id);
        if (Input::hasfile('car_img')) {
           $file=Input::file('car_img');
           $file->move(public_path(). '/images/car', $file->getClientOriginalName());
           $car->car_img=$file->getClientOriginalName();
        }
        $car->car_category          = $request->car_category;
        $car->brand_id          = $request->brand_id;
        $car->car_model          = $request->car_model;
        $car->car_desc          = $request->car_desc;
        
        $car->update();

        return redirect()->Route('cars.index')->with('message', "Data Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();
        return redirect()->Route('cars.index')->with('message', "Data Successfully Deleted");
    }
}
