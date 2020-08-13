<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Redeem;
use StdClass;

class RedeemController extends Controller
{
    public function redeemList(Request $request)
    {
    	$redeem = Redeem::where('user_id', $request->user()->id)
    						->get();
    	$response = new StdClass;
        $status = 200;
        $help_text = "Every 6 washes will trigger alert to the admin on who has done 6 washes. (Admin will send out cleaning solution to washer for every 6 washes).\n '?' upon clicking it.";
        $message = "Car wash not available. Refresh and retry";
        $washes = rand(0,6);
        if ($redeem){
            $response->redeem_list = $redeem;
            $message = "data retrieved successfully";
            $status = 200;
        }
        $response->total_washes = $washes;
        $response->help_text = $help_text;
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }
}
