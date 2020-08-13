<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromoCode;
use StdClass;
class PromoController extends Controller
{
    public function validatePromoCode(Request $request) 
    {
        $response = new StdClass;
        $status = 400;
        $message = 'The Code is invalid';
        $promocode = $request->promocode;
        $user_id = $request->user()->id;

        $Promocodes = PromoCode::where('status', '1')
                            ->where('promo_code', $promocode)
                            ->where('usable', 1)
                            ->select('promo_code','amount','message','promo_type','usage_type','user_id')
                            ->first();
        if ($Promocodes){
            if ($Promocodes->usage_type == 'single' || (isset($Promocodes->user_id) && $Promocodes->user_id == $user_id))
            $status = 200;
            $response->Promocodes = $Promocodes;
            $message = $promocode->message; 
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);

    }

    public function promocodelist(Request $request)	
    {
    	$response = new StdClass;
    	$status = 400;
    	$message = 'The Code is invalid';
    	$user_id = $request->user()->id;

    	$Promocodes = PromoCode::where('status', 'active')
    						->where('usable', 'true')
    						->select('promo_code', 'message')
    						->get();
    	
		$response->promocodes = $Promocodes;
    	$response->status = $status;
    	$response->message = $message;
    	return response()->json($response);

    }
}
