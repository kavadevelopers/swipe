<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StdClass;
use App\Reward;
use App\UserReward;
use App\MyReward;

class RewardController extends Controller
{
    public function rewards(Request $request)
    {
        $response = new StdClass;
        $status = 200;
        $message = "No rewards found";
        $reward_point = 0;
        $rewards = Reward::
                            // where('user_id', $request->user()->id)->
                            select('job_id as job_name', 'reward_point', 'created_at')->
                            get();
        if ($rewards){
            foreach ($rewards as $key => $value) {
                $reward_point += $value->reward_point;
            }
            $response->reward_points = $reward_point;
            $response->rewards = $rewards;
            $status = 200;
            $message = "Fetched successfully";

        }



        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function userrewards(Request $request)
    {
        $response = new StdClass;
        $status = 200;
        $message = "No rewards found";
        $booking_count = 8;
        $terms = array();
        for ($i=0; $i < 5; $i++) { 
            array_push($terms, "This is condition $i");
        }
        // if ($rewards){
            
            $response->booking_count = $booking_count;
            $response->terms = $terms;
            $status = 200;
            $message = "Fetched successfully";

        // }



        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function redeemrewards(Request $request)
    {
        $response = new StdClass;
        $status = 200;
        $message = "No rewards found";
        $booking_count = 1;
        
        // if ($rewards){
            
            $response->booking_count = $booking_count;
            // $response->terms = $terms;
            $status = 200;
            $message = "Reward Redeemed";

        // }



        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function rewardlists(Request $request)
    {
        $response = new StdClass;
        $status = 200;
        $message = "No rewards found";
        $reward_point = 0;

        $rewards = Reward::
                            // where('user_id', $request->user()->id)->
                            // select('job_id as job_name', 'reward_point', 'created_at')->
                            get();
        $result = array();

        if ($rewards){
            foreach ($rewards as $key => $value) {
                $obj = new StdClass;
                $obj->point = 0;
                $obj->discount = 0;
                $obj->icon = 0;
                $obj->total_value = 0;
                array_push($result, $obj);
                $reward_point += $value->reward_point;
            }
            $response->rewards = $result;
            $response->rewards = $rewards;
            $status = 200;
            $message = "Fetched successfully";

        }



        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function myrewards(Request $request)
    {
    	$response = new StdClass;
        $status = 200;
        $message = "No rewards found";
        $reward_point = 0;

        $rewards = MyReward::
        					// where('user_id', $request->user()->id)->
        					// select('job_id as job_name', 'reward_point', 'created_at')->
                            leftJoin('rewards', 'rewards.id', '=', 'my_rewards.reward_id')
                            ->where('rewards.user_id', $request->user()->id)
        					->get();
        if ($rewards){
        	foreach ($rewards as $key => $value) {
        		$reward_point += $value->reward_point;
        	}
            $response->reward_points = $reward_point;
            $response->rewards = $rewards;
            $status = 200;
            $message = "Fetched successfully";

        }



        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }
}
