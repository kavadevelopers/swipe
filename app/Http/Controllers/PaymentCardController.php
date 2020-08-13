<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentCard;
use App\Profile;
use StdClass;
use Validator;
use Stripe;

class PaymentCardController extends Controller
{
    public function addMyCard(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
		$validator = Validator::make($request->all(), [
            'card_no'        => 'required|unique:payment_cards',
            'expiry_month'        => 'required',
            'expiry_year'        => 'required',
            'name'        => 'required',
               
		], [
            'unique' => 'Card already exist',
        ]);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()],200);
        }  
		$profile = Profile::where('user_id',$user_id)->first();
		try {
			$stripe_card = Stripe::sources()->create([
				'type' => 'card',
				'token' => $request->stripe_card_id,
				'usage' => 'reusable',
				'owner' => [
					'email' => $request->user()->email
				],
			]); 
			$source = Stripe::sources()->attach($profile->customer_key, $stripe_card['id']);
			// "",
		}catch (\Throwable $th) {
			 $response->status = $th->getCode();
			 $response->message = $th->getMessage();
			 return response()->json($response);     
		}
        $mycard = new PaymentCard;
		$mycard->card_no      = $request->card_no;
        $mycard->stripe_card_id      = $stripe_card['id'];
        $mycard->expiry_month      = $request->expiry_month;
        $mycard->status        = $request->status;
        $mycard->expiry_year      = $request->expiry_year;
        $mycard->user_id        = $user_id;    
		$card = PaymentCard::where([
			['user_id', '=', $user_id],
			['primary', '=', true]
		])->get();

		$hasCard = PaymentCard::where([
			['user_id', '=', $user_id]
		])->get();
		$mycard->primary = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);
		if($card && count($card) > 0 && $mycard->primary == true){
			PaymentCard::where([
				['user_id', '=', $user_id],
				['primary', '=', true]
			])->update(['primary' => false]);
			$mycard->primary        = true;        
		}elseif(count($hasCard) <= 0){
			$mycard->primary        = true;
        }

        $mycard->type        = $request->type;        
        $mycard->name        = $request->name;        
        $mycard->save();


        if ($mycard){
                $response->mycards = $mycard;
                $status = 200;
                $message = "Card information saved Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
	}

	public function editMyCard(Request $request){
	    $user_id = $request->user()->id;
	    $response = new StdClass;
	    $status = 400;
	    $message = "Something Went Wrong!!!";
	    $validatedData = $request->validate([
	        'card_no'        => 'required',
            'expiry_month'        => 'required',
            'expiry_year'        => 'required',
            'name'        => 'required',
	        ]);

	    

	    $mycard = PaymentCard::where('user_id', $user_id)->where('id', $request->card_id)->first();
	    if ($mycard){
		    $mycard->card_no      = $request->card_no;
	        $mycard->expiry_month      = $request->expiry_month;
	        $mycard->expiry_year      = $request->expiry_year;
	        $mycard->type        = $request->type;        
	        $mycard->user_id        = $user_id;  
	        $mycard->status        = $request->status;
			$mycard->name        = $request->name;
			$card = PaymentCard::where([
				['user_id', '=', $user_id],
				['primary', '=', true]
			])->get();
	
			$mycard->primary = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);
			if($card && count($card) > 0 && $mycard->primary == true){
				PaymentCard::where([
					['user_id', '=', $user_id],
					['primary', '=', true]
				])->update(['primary' => false]);
				$mycard->primary        = true;        
			}
		    $mycard->update();
	    }
        else{
            $message = "This card is not yours";
        }

	    if ($mycard){
	            $response->mycards = $mycard;
	            $status = 200;
	            $message = "Card information saved Successfully";

	    }   

	    $response->status = $status;
	    $response->message = $message;
	    return response()->json($response);     
	}  

    public function setPrimaryCard(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $validator = Validator::make($request->all(), [
            'card_id'        => 'required',
            'primary'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
        $mycard = PaymentCard::where('user_id', $user_id)->where('id', $request->card_id)->first();
        if ($mycard){       
            $card = PaymentCard::where([
                ['user_id', '=', $user_id],
                ['primary', '=', true]
            ])->get();
                
            $mycard->primary = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);
            if($card && count($card) > 0 && $mycard->primary == true){
                PaymentCard::where([
                    ['user_id', '=', $user_id],
                    ['primary', '=', true]
                ])->update(['primary' => false]);
                $mycard->primary        = true;        
            }
            $mycard->update();
        }
        else{
            $message = "This card is not yours";
        }

        if ($mycard){
                $response->mycards = $mycard;
                $status = 200;
                $message = "Set Primary card Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
    }

	public function deleteMyCard(Request $request){
	    $user_id = $request->user()->id;
	    $response = new StdClass;
	    $status = 400;
	    $message = "Something Went Wrong!!!";

		$mycard = PaymentCard::where('user_id', $user_id)->where('id', $request->card_id)->first();
		if($mycard){
			if($mycard->primary){
				$primaryCard = PaymentCard::where([
                    ['user_id', '=', $user_id],
                    ['primary', '!=', true]
				])->orderBy('id')->first();
				if($primaryCard){
					$primaryCard->primary = true;
					$primaryCard->save();
				}
			}
			$mycard = $mycard->delete();
		}


	    if ($mycard){
			$response->mycard = $mycard;
			$status = 200;
			$message = "Card information deleted Successfully";

	    }   

	    $response->status = $status;
	    $response->message = $message;
	    return response()->json($response);     
	}

	public function viewMycard(Request $request)
	{
	$response = new StdClass;
	$status = 400;
	$message = "Something Went Wrong!!!";
	$user_id = $request->user()->id;
	$mycard = PaymentCard::where('user_id', $user_id)->orderBy('status', 'Desc')->get();
	if ($mycard){
	    $status = 200;
	    $message = 'Data Processed';
	    $response->my_cards = $mycard;
	}
	$response->status = $status;
	$response->message = $message;
	return response()->json($response);

	}
}
