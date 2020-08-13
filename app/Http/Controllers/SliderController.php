<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sliderimages;
use Input;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $slides = Sliderimages::all();
        return view('admin.sliderimages', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.add_sliderimg');
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
            'slide_img' => 'required'            
        ]);
        $slider = new Sliderimages;
        if (Input::hasfile('slide_img')) {
           $file=Input::file('slide_img');
           $file->move(public_path(). '/images/slider', $file->getClientOriginalName());
           $slider->slide_img=$file->getClientOriginalName();
        }
        $slider->name          = $request->name;
        $slider->description   = $request->description;
        
        $slider->save();

        return redirect()->Route('slider_img.index')->with('message', "Data Successfully Inserted");
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
        $slides = Sliderimages::where('id', $id)->first();
        return view('admin.add_sliderimg', compact('slides'));
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
        $slider = Sliderimages::find($id);
        if (Input::hasfile('slide_img')) {
           $file=Input::file('slide_img');
           $file->move(public_path(). '/images/slider', $file->getClientOriginalName());
           $slider->slide_img=$file->getClientOriginalName();
        }
        $slider->name          = $request->name;
        $slider->description   = $request->description;
        
        $slider->update();

        return redirect()->Route('slider_img.index')->with('message', "Data Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Sliderimages::find($id);
        $slider->delete();
        return redirect()->Route('slider_img.index')->with('message', "Data Successfully Deleted");
    }
}
