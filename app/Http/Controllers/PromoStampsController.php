<?php

namespace App\Http\Controllers;

use App\PromoStamps;
use App\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use StdClass;
use DB;

class PromoStampsController extends Controller
{
    public function redeemStamp(Request $request)
    {
        $response = new StdClass;
        $profile = Profile::where('user_id',$request->user()->id)->first();
        $user_id= $request->user()->id;
        $message = 'Promo Can not reddem';
        if( $profile->unrewarded_booking >= 4 && $profile->unrewarded_booking < 8){
            $data = array('type'=>"Mini3");
            $data['user_id'] = $request->user()->id;
            $data['code'] = Str::random(8);
            $data['isValid'] = 'valid';
            $data['expired_at'] =  Carbon::now()->addMonths(6);
            $stamp = PromoStamps::create($data);
            $profile->unrewarded_booking -= 4;
            $profile->save();
            $message = "Congratulations!\n You have successfully redeemed $3 off!\n T&C applies.";
            $result = NotificationController::sendPushNotification($message,$user_id,'reedeem_stamp',"Rewards",'customer');
        }elseif($profile->unrewarded_booking == 8){
            $data = array('type'=>"Mini7");
            $data['user_id'] = $request->user()->id;
            $data['code'] = Str::random(8);
            $data['isValid'] = 'valid';
            $data['expired_at'] =  Carbon::now()->addMonths(6);
            $stamp = PromoStamps::create($data);
            $profile->unrewarded_booking = 0;
            $profile->save();
            $message = "Congratulations!\n You have successfully redeemed $7 off\n T&C applies.";
            $result = NotificationController::sendPushNotification($message,$registatoin_ids,'reedeem_stamp',"Rewards",'customer');
            $message = 'Promo Reddemed';
        }
        $response->message = $message;
        return response()->json($response);    
    }

    public function redeemPromo(Request $request)
    {
        $response = new StdClass;
        try {
            $promoCode = $request->promo;
            $stamp = PromoStamps::where('user_id',$request->user()->id)->where('code',$promoCode)->where('isValid','valid')->first();
            $promo = PromoCode::where('status', '1')
                                ->where(['promo_code' => $promocode, 'user_id' => $request->user()->id])
                                ->select('*')
                                ->first();
            $data = array(
                'reward_value' => 0
            );
            if(!$stamp){
                $message = 'There were no Promocode or all code may be expired';
                $response->message = $message;
                return response()->json($response);    
            }
            $data['code'] = $stamp ? $stamp->code : ''; 
            if($stamp->type == "Mini3" &&  $stamp->isValid == 'valid'){
                $data['reward_value'] = 3;
            }elseif($stamp->type == "Mini7" &&  $stamp->isValid == 'valid'){
                $data['reward_value'] = 7;
            }elseif($promo && $promo->amount){
                $data['reward_value'] = $promo->amount;
            }
            $stamp->isValid = 'used';
            $stamp->save();
            $message = 'Successfully redeemed';
            $response->data = $data;
            $response->message = $message;
            return response()->json($response);    
        } catch (\Throwable $th) {
            $message = 'ooops! something went wrong';
            $response->data = [];
            $response->message = $message;
            return response()->json($response);    
        }
    }

    public function validatePromoCode(Request $request)
    {
        $response = new StdClass;
        $response->status = 200;
        $adminPromo = DB::table('promocodes')->where('promo_code',$request->promo)->where('status',1)->where('start_date','>=',date('Y-m-d'))->where('end_date','<=',date('Y-m-d'))->first();



        if($adminPromo && $adminPromo->counter_usage < $adminPromo->count_limit){

            $message = 'This code is valid';
            $response->amount = $adminPromo->amount;
            $response->type   = "admin";
            $response->status = 200;
            $response->message = $message;
            return response()->json($response);

        }else{
            $message = 'ooops! something went wrong please try again';
            $response->data = [];
            $response->status = 400;
            $response->message = $message;
            return response()->json($response); 
        }

            // try {
            //     $promoCode = $request->promo;

            //     $stamp = PromoStamps::where('user_id',$request->user()->id)->where('code',$promoCode)->where('isValid','valid')->first();

            //     if(!$stamp){
            //         $message = 'The promocode is invalid or expired';
            //         $response->message = $message;
            //         $response->status = 401;
            //         return response()->json($response);    
            //     }
            //     switch ($stamp->type) {
            //         case 'Mini7':
            //             $discount = 7;
            //         break;
            //         case 'Mini3':
            //             $discount = 3;
            //         break;
                    
            //         default:
            //             $discount = 0;
            //             break;
            //     }
            //     // $data['code'] = $stamp ? $stamp->code : '';
            //     $message = 'This code is valid';
            //     $response->type = $discount;
            //     $response->status = 200;
            //     $response->message = $message;
            //     return response()->json($response);    
            // } catch (\Throwable $th) {
            //     $message = 'ooops! something went wrong please try again';
            //     // $response->data = [];
            //     $response->status = 400;
            //     $response->message = $message;
            //     return response()->json($response);    
            // }
    }

    public function iredeemPromo(Request $request)
    {
        $response = new StdClass;
        try {
            $promoCode = $request->promo;
            $stamp = PromoStamps::where('user_id',$request->user()->id)->where('code',$promoCode)->where('isValid','used')->first();
            if(!$stamp){
                $message = 'There were no Promocode or all code may be expired';
                $response->message = $message;
                return response()->json($response);    
            }
            $stamp->isValid = 'valid';
            $stamp->save();
            $message = 'Successfully removed';
            $response->data = $stamp;
            $response->message = $message;
            return response()->json($response);    
        } catch (\Throwable $th) {
            $message = 'ooops! something went wrong';
            $response->data = [];
            $response->message = $message;
            return response()->json($response);    
        }
    }


    public function promoList(Request $request)
    {
        $response = new StdClass;
        try {
            $stamp = PromoStamps::where('user_id',$request->user()->id)
                        ->whereDate('expired_at', '<', Carbon::now())
                        ->where('isValid','valid')
                        ->update(['isValid'=>'expired']);
            $stamp = PromoStamps::where('user_id',$request->user()->id)->where('isValid','!=','used')->whereDate('expired_at', '>=', Carbon::now())->get();
            $message = 'Data fetched';
            $response->stamp = $stamp;
            $response->message = $message;
            return response()->json($response);    
        } catch (\Throwable $th) {
            $message = 'ooops! something went wrong';
            $response->data = [];
            $response->message = $message;
            return response()->json($response);    
        }
    }

    public function promoHistory(Request $request)
    {
        $response = new StdClass;
        try {
            $stamp = PromoStamps::where('user_id',$request->user()->id)->where('isValid','!=','valid')->get();
            $response->stamp = $stamp;
            $message = 'Data fetched';
            $response->message = $message;
            return response()->json($response);    
            } catch (\Throwable $th) {
                $message = 'ooops! something went wrong';
            $response->data = [];
            $response->message = $message;
            return response()->json($response);    
        }
    }

    public function userRewardsRedeem(Request $request)
    {
        $response = new StdClass;
        $response->booking_count = 0;
        $response->status = 200;
        try {
            $booking_counts =  Profile::where('user_id',$request->user()->id)->first()->unrewarded_booking;
            $message = 'Data fetched';
            $response->booking_count = $booking_counts ?? 0;
            $terms = array();
            for ($i=0; $i < 5; $i++) { 
                array_push($terms, "This is condition $i");
            }
            $response->terms = $terms;
            
        } catch (\Throwable $th) {
            $response->booking_count = 0;
            $message = 'ooops! something went wrong';
            $response->status = 400;
        }
        $response->message = $message;
        return response()->json($response);  
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
     * @param  \App\PromoStamps  $promoStamps
     * @return \Illuminate\Http\Response
     */
    public function show(PromoStamps $promoStamps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PromoStamps  $promoStamps
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoStamps $promoStamps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PromoStamps  $promoStamps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromoStamps $promoStamps)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PromoStamps  $promoStamps
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoStamps $promoStamps)
    {
        //
    }
}
