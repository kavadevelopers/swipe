<?php

namespace App\Http\Controllers;

use App\WasherBankDetail;
use Illuminate\Http\Request;
use StdClass;
use File;
use Image;
class WasherBankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $response = new StdClass;
        $status = 200;
        $message = "Please add all data";
        try {
            //code...
            $input = $request->all();
            $detail = array(
                'user_id'          => $request->user()->id,
                'bank_name'            => $input['bank_name'],
                'account_number'            => $input['account_number'],
                'account_holder'            => $input['account_holder']
            );
            $user = User::where('id', $request->user()->id)->first();
            $user->user_type = "washer";
            $user->update(); 
        
            if($request->file('image')){
                $image = $request->file('image');
                $path = public_path().'/image/'.$request->user()->id."/";
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $path = public_path();
                $filename = '/image/'.$request->user()->id."/".time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save(public_path($filename));
                $detail['image'] =$filename;
            }
            $data = WasherBankDetail::updateOrCreate(
                ['user_id' => $request->user()->id],
                $detail
            );
            $status = 200;
            $message = "Details Added";
        } catch (\Throwable $th) {
            dd($th);
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WasherBankDetail  $washerBankDetail
     * @return \Illuminate\Http\Response
     */
    public function show(WasherBankDetail $washerBankDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WasherBankDetail  $washerBankDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(WasherBankDetail $washerBankDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WasherBankDetail  $washerBankDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WasherBankDetail $washerBankDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WasherBankDetail  $washerBankDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(WasherBankDetail $washerBankDetail)
    {
        //
    }
}
