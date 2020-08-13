<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarWashBooking;
use App\PushNotification;
use App\MyCar;
use App\PaymentCard;
use App\PromoCode;
use App\PromoStamps;
use App\Profile;
use StdClass;
use Stripe;
use Validator;
use Carbon\Carbon;

class CarWashBookingController extends Controller
{
    public function addcarwashbooking(Request $request){
        $user_id = $request->user()->id;
        // \Log::info("This is a message from a controller");
        // \Log::info(print_r($request->toArray(), true));
        // \Log::info($user_id);
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $start_time =  Carbon::parse($request->start_time)->setTimezone('UTC');
        $end_time =  Carbon::parse($request->end_time)->setTimezone('UTC');
        $time = Carbon::now("UTC");
        $validator = Validator::make($request->all(), [
            'vehicle_id'        => 'required',
            'card_id'           => 'required',
            'date'              => 'required',
            // 'start_time'        =>  ['required',function ($attribute, $value, $fail) use($time,$start_time,$end_time) {
            //                             if (!(9 <= $time->diffInMinutes($start_time,false))) {
            //                                 $fail('Start time must be after 10 minutes from now.');
            //                             }
            //                         }], //9 <= $time->diffInMinutes($start_time,false)
            // 'end_time'         =>   ['required',function ($attribute, $value, $fail) use($time,$start_time,$end_time) {
            //                             if (!(6 >= ($start_time->diffInMinutes($end_time,false)/60))) {
            //                                 $fail('End time must be less then  6 hours from Start time.');
            //                             }
            //                         }], //6 >= ($time->diffInMinutes($end_time,false)/60)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
        // if($time->between($morning, $evening, true)) {
            //current time is between morning and evening
        // } else {
        //     //current time is earlier than morning or later than evening
        // }
        $notes = 'No special notes';
        if ($request->notes!=null){
            $notes = $request->notes;
        }
        $card = PaymentCard::where([
            ['user_id', '=', $user_id],
            ['id', '=', $request->card_id]
        ])->first();
        // dd($vehicle);
        $profile = Profile::where('user_id',$user_id)->first();
        try {
            //code...
            // $charge = Stripe::charges()->create([
            //     'customer' => $profile->customer_key,
            //     'currency' => 'INR',
            //     'amount'   => $request->fare,
            //     'source' => $card->stripe_card_id,
            //     'capture' => true,
            //     'description' => 'Swipe Booking',
            // ]);
            $charge = Stripe::paymentIntents()->create([
                'amount' => $request->fare,
                'currency' => 'INR',
                'payment_method_types' => [
                    'card',
                ],
                'customer' => $profile->customer_key,
                'capture_method' => 'manual'
            ]);
            $charge = Stripe::paymentIntents()->confirm( $charge['id'], [
                'payment_method' => $card->stripe_card_id,
            ]);
        } catch (\Throwable $th) {
            $response->status = $th->getCode();
            $response->message = $th->getMessage();
            return response()->json($response);   
        }
        if($charge['charges']['data'][0]['amount_refunded'] == 0 && empty($charge['charges']['data'][0]['failure_code']) && $charge['charges']['data'][0]['paid'] == 1)
        {
            $mybooking = new CarWashBooking;
            $mybooking->payment_status = "hold";
            $mybooking->charge_id = $charge['id'];
            $mybooking->location      = $request->location;
            $mybooking->vehicle_id      = $request->vehicle_id;
            $mybooking->user_id        = $user_id;        
            $mybooking->date        = Carbon::parse($request->date)->format('Y-m-d');
            $mybooking->start_time        = $request->start_time;    
            $mybooking->end_time        = $request->end_time;        
            $mybooking->card_id        = $request->card_id;        
            $mybooking->lot_no        = $request->lot_no;        
            $mybooking->fare        = $request->fare;
            $mybooking->payment_type        = $request->payment_type; 
            $mybooking->lat             = $request->lat??0; 
            $mybooking->lon             = $request->lon??0; 
            $mybooking->notes        = $notes;
            $mybooking->isPromo        = false;
            $mybooking->job_code        = Carbon::now()->timestamp."-".$user_id."-".$request->date."-".$request->lot_no;
            if(!is_null($card)){
                $mybooking->card_no        = $card->card_no;
                $mybooking->card_type        = $card->card_type;
            }
            $mybooking->user_name = $request->user()->name;
            $vehicle = MyCar::join('carmodels', 'carmodels.id', '=', 'my_cars.car_model')->join('brands', 'brands.id', '=', 'my_cars.car_brand')->where('my_cars.id', $request->vehicle_id)->first();
            if(!is_null($vehicle)){
                $mybooking->model_name = $vehicle->model_name;
                $mybooking->brand_name = $vehicle->brand_name;
                $mybooking->vehicle_no = $vehicle->vehicle_no;
                $mybooking->brand_img = $vehicle->brand_img;
                $mybooking->car_image = $vehicle->car_image;
                $mybooking->brand_id = $vehicle->brand_id;
                $mybooking->model_img = $vehicle->model_img;
                $mybooking->model_desc = $vehicle->model_desc;
                $mybooking->color_code = $vehicle->color_code;
                $mybooking->color_name = $vehicle->color_name;
                $mybooking->type = $vehicle->type;
                $mybooking->partner_price        = $vehicle->partner_price;    
                $mybooking->user_price        = $vehicle->user_price;    
            }
                // $profile = Profile::where('user_id',$user_id)->first();
                // dd($profile);\
            if(!is_null($request->promo)){
                $promoCode = $request->promo;
                $stamp = PromoStamps::where('user_id',$request->user()->id)->where('code',$promoCode)->where('isValid','valid')->first();
                if(!$stamp){
                    $mybooking->isPromo        = false;  
                }else{
                    $stamp->isValid = 'used';
                    $mybooking->booking_promp        = $request->promo;  
                    $mybooking->isPromo        = true;
                    $stamp->save();
                }
                
            }
            $mybooking->save();
            if ($mybooking){
                // is_booked
                MyCar::where('id', $request->vehicle_id)->update(['is_booked' => true]);
                $response->mybooking = $mybooking;
                $status = 200;
                $message = "Car wash booking saved Successfully";
            }
            else{ 
                $is_success = 400; $message = "Something went wrong";
            }
            $response->status = $status;
            $response->message = $message;
            $response->nexturl = url("/paymentgateway");
        }else{
            $is_success= 400;
            $message = "Payment failure";
        }
        return response()->json($response);     
    }

    public function cancelcarwashbooking(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "No Booking Found!!!";
       

        $mybooking = CarWashBooking::where('id', $request->wash_id)->where('user_id', $user_id)->first();
        if ($mybooking){
            if($mybooking->status == 'Started' || $mybooking->status == 'Cancelled'){
                $message = "Car wash booking can not cancel Or already cancled";
                $response->status = '';
                $response->message = $message;
                return response()->json($response);
            }
            $mybooking->status      = 'Cancelled';
            try {
                $paymentIntent = Stripe::paymentIntents()->cancel($mybooking->charge_id);
            } catch (\Throwable $th) {
                $response->status = 400;
                $response->message = "Something went wrong! Please try again";
                return response()->json($response);  
            }
            $promoCode = $mybooking->booking_promp;
            $stamp = PromoStamps::where('user_id',$request->user()->id)->where('code',$promoCode)->where('isValid','used')->first();
            $push = "Sorry, the booking has been cancelled by vehicle owner. Please select another booking.";
            $result = NotificationController::sendPushNotification($push,$mybooking->accepted_by,'cancle_booking','Booking','washer');
            if($stamp){
                $stamp->isValid = "valid";
                $stamp->save();
            }
            // dd($stamp);
            $mybooking->update();
            MyCar::where('id', $mybooking->vehicle_id)->update(['is_booked' => false]);
            $status = 200;
            $message = "Car wash booking cancelled successfully";
            // if($mybooking->isPromo == true){
            //     $profile = Profile::where('user_id',$user_id)->first();
            //     $profile->unrewarded_booking -= 1;
            //     $profile->total_booking -= 1;
            //     $profile->save();
            // }
        }

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
    } 

 public function viewMyCarWashBooking(Request $request)
 {
    $response = new StdClass;
    $status = 400;
    $message = "Something Went Wrong!!!";
    $user_id = $request->user()->id;
    $mybooking = CarWashBooking::with(['washer_profile','unread_message_user','washers:id,name'])->
    // leftJoin('payment_cards', 'payment_cards.id', '=', 'car_wash_bookings.card_id')
    // ->select('car_wash_bookings.*', 'payment_cards.card_no')
    where('car_wash_bookings.user_id', $user_id)
    ->whereIn('car_wash_bookings.status', ['Completed','Cancelled','Expired'])->orderBy('updated_at','desc')->get();
    // $mylist = array();
    // foreach ($mybooking as $key => $value) {
    //     if ($value->status == 'Completed' || $value->status == 'Cancelled'){
    //         $vehicle = MyCar::join('carmodels', 'carmodels.id', '=', 'my_cars.car_model')->join('brands', 'brands.id', '=', 'my_cars.car_brand')->where('my_cars.id', $value->vehicle_id)->first();

    //         if ($vehicle){
    //             $value->brand_name = $vehicle->brand_name;
    //             $value->car_image = $vehicle->car_image;
    //             $value->model_name = $vehicle->model_name;
    //             array_push($mylist, $value);
    //         }
    //     }
    // }
    if ($mybooking){
        $status = 200;
        $message = 'Data Processed';
        $response->my_booking = $mybooking;
    }
    $response->status = $status;
    $response->message = $message;
    return response()->json($response);

 }

 public function viewMyCarWashScheduleBooking(Request $request)
 {
    $response = new StdClass;
    $status = 400;
    $message = "Something Went Wrong!!!";
    $user_id = $request->user()->id;
    $mybooking = CarWashBooking::with(['washer_profile','unread_message_user','washers:id,name'])->
    // join('payment_cards', 'payment_cards.id', '=', 'car_wash_bookings.card_id')
    // ->select('car_wash_bookings.*', 'payment_cards.card_no','payment_cards.type as card_type')
    where('car_wash_bookings.user_id', $user_id)
    ->whereIn('car_wash_bookings.status', ['Pending','Accepted','Started'])
    ->orderBy('id','DESC')
    ->get();
    // $mylist = array();
    // foreach ($mybooking as $key => $value) {
    //     if ($value->status == 'Pending' || $value->status == 'Accepted'){
    //         $vehicle = MyCar::join('carmodels', 'carmodels.id', '=', 'my_cars.car_model')->join('brands', 'brands.id', '=', 'my_cars.car_brand')->where('my_cars.id', $value->vehicle_id)->first();
    //         if ($vehicle){
    //             $value->brand_name = $vehicle->brand_name;
    //             $value->car_image = $vehicle->car_image;
    //             $value->model_name = $vehicle->model_name;
    //             $value->type = $vehicle->type ;
    //             // array_push($mylist, $value);
    //         }
    //     }
    // }
    if ($mybooking){
        $status = 200;
        $message = 'Data Processed';
        $response->my_booking = $mybooking;
    }
    $response->status = $status;
    $response->message = $message;
    return response()->json($response);

 }

 public function washListDate(Request $request)
    {
        $washes = CarWashBooking::where('user_id', $request->user()->id)->select('date')->groupBy('date')->get();
        $response = new StdClass;
        $status = 200;
        $message = "Car wash dates not available. Refresh and retry";
        if ($washes){
            $response->wash_dates = $washes;
            $message = "data retrieved successfully";
            $status = 200;
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);

    }

    public function washListByDate(Request $request)
    {
        $date = $request->date;
        $washes = CarWashBooking::where('date', $request->date)
                                ->where('user_id', $request->user()->id)
                                ->select('*')
                                ->get();

        $response = new StdClass;
        $status = 200;
        $message = "Car wash not available. Refresh and retry";
        if ($washes){
            $response->wash_dates = $washes;
            $message = "data retrieved successfully";
            $status = 200;
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }

    public function washListByWeek(Request $request)
    {
        $week = $request->week;
        $start_date = date("d-m-Y", strtotime('monday this week', strtotime($week)));
        $end_date = date("d-m-Y", strtotime('sunday this week', strtotime($week)));
        $washes = CarWashBooking::where('date','>=' ,$start_date)
                                ->where('date','<=' ,$end_date)
                                ->where('user_id', $request->user()->id)
                                ->select('*')
                                ->get();

        $response = new StdClass;
        $status = 200;
        $message = "Car wash not available. Refresh and retry";
        if ($washes){
            $response->wash_dates = $washes;
            $message = "data retrieved successfully";
            $status = 200;
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);

    }

    public function washListweek(Request $request)
    {
        $washes = CarWashBooking::where('user_id', $request->user()->id)->select('date')->groupBy('date')->get();
        $response = new StdClass;
        $status = 200;
        $message = "Car wash dates not available. Refresh and retry";
        $weeklist = array();
        if ($washes){
            foreach ($washes as $key => $value) {
                $date = $value->date;
                $time = strtotime($date);
                $week = date('W', $time);
                if (in_array($week, $weeklist) < 1){
                    array_push($weeklist, $week);
                }
            }
            $response->wash_week = $weeklist;
            $message = "data retrieved successfully";
            $status = 200;
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);

    }

    public function carWashDetail(Request $request)
    {
        // $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "No Booking Found!!!";
        $mybooking = CarWashBooking::where('id', $request->wash_id)->first();
        if ($mybooking){
            $status = 200;
            $message = "Car wash booking details";
            $mybooking->job_code = $mybooking->job_code ?? "211212-".$mybooking->id."-02-1111-01";
            $mybooking->save();
            $response->booking = $mybooking;
        }

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
    }

    public function rateWasher(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Already Voted or Not able to vote";
        $washer_id = $request->washer_id;
        $type = $request->type;
        $profile = Profile::where('user_id',$washer_id)->first();
        $mybooking = CarWashBooking::where('id', $request->wash_id)->first();
        if($profile && !is_null($profile) && $mybooking && (!$mybooking->is_rated)){
            switch ($type) {
                case 'upvote':
                case 'like':
                    $profile->upvote_count += 1;
                break;
                case 'downvote':
                    case 'dislike':
                        $profile->downvote_count += 1;
                    break;
            }
            $profile->save();
            $status = 200;
            $message = "Voted";
            $mybooking->is_rated = true;
            $mybooking->save();
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);  
    }
}
