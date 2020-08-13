<?php

namespace App\Http\Controllers;

use App\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privacy = Privacy::where('id',1)->first();
        return view('admin.privacy.index', ['privacy' => $privacy]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function show(Privacy $privacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataArr = Privacy::where('id',$id)->first();
        

        // $form = Notifications::where('id',$id)->first()->toArray();
        if(empty($dataArr)){
            $dataArr = array('id' => $id);
            $dataArr['title']    = "Privacy";
            $dataArr['description']      = "";
        }
        else{
            $dataArr = $dataArr->toArray();
        }
        return view('admin.privacy.edit')->with('form', (object)$dataArr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->toArray()); 
        $input = $request->all();
        $dataArr = array(
            'title'          => $input['title'],
            'description'            => $input['description'],
        );
        Privacy::updateOrCreate([
           'id'   => $id,
        ],$dataArr);
        // $privacy->update($dataArr);
        return redirect('/admin/privacy')->with("success", "Privacy updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Privacy $privacy)
    {
        //
    }
}
