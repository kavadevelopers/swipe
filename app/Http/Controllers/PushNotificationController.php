<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PushNotification;
use StdClass;

class PushNotificationController extends Controller
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
        $message = 'Please set all field';
        $response->status = 400;
        $user_id = $request->user_id ??$request->user()->id;
        $notification_token = $request->notification_token;
        $os = isset($request->os) && !is_null($request->os) ? $request->os : 'android';  
        if($user_id && $notification_token){
            $data = PushNotification::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'os' => $os,
                ],
                [
                    'notification_token' => $notification_token,
                    'counter' => 0,
                ]
            );
            $message = 'Token added';
            $response->status = 200;
        }
        $response->message = $message;
        return response()->json($response);  

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
