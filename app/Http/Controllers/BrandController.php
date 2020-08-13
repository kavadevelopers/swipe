<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Input;
use File;
class BrandController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $brands = Brand::all();
        return view('admin.brands', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.add_brand');
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
            'brand_name' => 'required',            
            'brand_img' => 'required'            
        ]);
        $brand = new Brand;
        if (Input::hasfile('brand_img')) {
           $file=Input::file('brand_img');
           $filename= time().'.'.$file->getClientOriginalExtension();
           $directoryName = '/images/brand';
           if(!is_dir(public_path($directoryName))){
                //Directory does not exist, so lets create it.
                $result = File::makeDirectory(public_path($directoryName), 0777, true, true);
            }
           $file->move(public_path($directoryName), $filename);
           $brand->brand_img=$filename;
        }
        $brand->brand_name          = $request->brand_name;
        $brand->description   = $request->description;
        
        $brand->save();

        return redirect()->Route('brands.index')->with('message', "Data Successfully Inserted");
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
        $brands = Brand::where('id', $id)->first();
        return view('admin.add_brand', compact('brands'));
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
        $brand = Brand::find($id);
        if (Input::hasfile('brand_img')) {
           $file=Input::file('brand_img');
           $file->move(public_path(). '/images/brand', $file->getClientOriginalName());
           $brand->brand_img=$file->getClientOriginalName();
        }
        $brand->brand_name          = $request->brand_name;
        $brand->description   = $request->description;
        
        $brand->update();

        return redirect()->Route('brands.index')->with('message', "Data Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->Route('brands.index')->with('message', "Data Successfully Deleted");
    }
}
