<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carmodel;
use App\Brand;
use Input;
use DB;

class ModelController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $carmodels = DB::table('carmodels')
            ->join('brands', 'carmodels.brand_id', '=', 'brands.id')
            ->select('carmodels.id','carmodels.model_name','carmodels.brand_id','carmodels.model_desc','carmodels.model_img','carmodels.type','carmodels.status','carmodels.created_at','brands.brand_name')
            ->get();
        return view('admin.carmodels', compact('carmodels'));
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
        return view('admin.add_model', compact('brands'));
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
            'model_name' => 'required',           
            'brand_id' => 'required' ,           
            'type' => 'required'            
        ]);
        $carmodel = new Carmodel;
        if (Input::hasfile('model_img')) {
           $file=Input::file('model_img');
           $file->move(public_path(). '/images/carmodels', $file->getClientOriginalName());
           $carmodel->model_img=$file->getClientOriginalName();
        }
        $carmodel->model_name          = $request->model_name;
        $carmodel->brand_id          = $request->brand_id;
        $carmodel->type          = $request->type;
        $carmodel->model_desc          = $request->model_desc;
        
        $carmodel->save();

        return redirect()->Route('carmodels.index')->with('message', "Data Successfully Inserted");
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
        $carmodels = Carmodel::where('id', $id)->first();
        return view('admin.add_model', compact('carmodels','brands'));
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
        $carmodel = Carmodel::find($id);
        if (Input::hasfile('model_img')) {
           $file=Input::file('model_img');
           $file->move(public_path(). '/images/carmodels', $file->getClientOriginalName());
           $carmodel->model_img=$file->getClientOriginalName();
        }
        $carmodel->model_name          = $request->model_name;
        $carmodel->brand_id          = $request->brand_id;
        $carmodel->type          = $request->type;
        $carmodel->model_desc          = $request->model_desc;
        
        $carmodel->update();

        return redirect()->Route('carmodels.index')->with('message', "Data Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carmodel = Carmodel::find($id);
        $carmodel->delete();
        return redirect()->Route('carmodels.index')->with('message', "Data Successfully Deleted");
    }
}
