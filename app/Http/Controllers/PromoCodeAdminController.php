<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromoCode;

class PromoCodeAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PromoCode::all();
        return view('admin.promocodelist', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addpromocode');
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
            'promo_code' => 'required|unique:promo_codes',
            'amount' => 'required',
            'promo_type' => 'required',
            'usage_type' => 'required',
            'expiry_date' => 'required',
        ]);
        $PromoCode = new PromoCode;
        $PromoCode->promo_code      = $request->promo_code;
        $PromoCode->amount          = $request->amount;
        $PromoCode->promo_type      = $request->promo_type;
        $PromoCode->usage_type      = $request->usage_type;
        $PromoCode->user_id         = $request->user_id;
        $PromoCode->expiry_date     = $request->expiry_date;
        $PromoCode->message         = $request->message;
        $PromoCode->save();

        return redirect()->Route('promocode.index')->with('message', "Data Successfully Inserted");

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
        
        $promocode = PromoCode::where('id', $id)->first();
        return view('admin.addpromocode', compact('promocode'));
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
            'promo_code' => 'required',
            'amount' => 'required',
            'promo_type' => 'required',
            'usage_type' => 'required',
            'expiry_date' => 'required',
        ]);
        $PromoCode = PromoCode::find($id);
        $PromoCode->promo_code      = $request->promo_code;
        $PromoCode->amount          = $request->amount;
        $PromoCode->promo_type      = $request->promo_type;
        $PromoCode->usage_type      = $request->usage_type;
        $PromoCode->user_id         = $request->user_id;
        $PromoCode->expiry_date     = $request->expiry_date;
        $PromoCode->message         = $request->message;
        $PromoCode->update();

        return redirect()->Route('promocode.index')->with('message', "Data Successfully Updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PromoCode = PromoCode::find($id);
        $PromoCode->delete();
        return redirect()->Route('promocode.index')->with('message', "Data Successfully Deleted");
        
    }
}
