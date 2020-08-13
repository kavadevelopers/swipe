<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, DB, Hash, Mail, Illuminate\Support\Facades\Password;
use App\AccountSetting;
use StdClass;

class UserApiController extends Controller
{
     public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    public function create_epin(Request $request)
    {
        $response = new StdClass;
        $message = "No profile Found";
        $status = 400;
        $epin = $request->epin;
        $profile = Profile::where('user_id', $request->user()->id)->update(['epin' => $epin]);
        if ($profile){
            $message = "Epin Set successfully";
            $status = 200;
            $response->profile = $profile;
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }


    public function profileinfo(Request $request)
    {
        $id = $request->user()->id;
        $data = new StdClass;
        $data->status = 400;
        if ($id){
            $userdata = User::where('id', $id)
                            ->first(); 
            $user = new StdClass;
            $user->firstname = $userdata->firstname;
            $user->lastname = $userdata->lastname;
            $user->email = $userdata->email;
            $userProfileData = Profile::where('user_id', $id)->first();
            $user->dob="";
            $user->gender="";
            $user->profile_pic="";
            $user->mobile = $userdata->mobile;
            $user->epin = "";
            $user->profession="";
            
            

            if ($userProfileData){
                $user->dob = $userProfileData->dob;
                $user->gender = $userProfileData->gender;
                $user->profile_pic = $userProfileData->profile_pic;
                $user->epin = $userProfileData->epin;
                $user->profession = $userProfileData->profession;
            }
            $data->profile = $user;
            $data->status = 200;
        }
        return response()->json($data);
    }


    public function editprofileinfo(Request $request)
    {
        $id = $request->user()->id;
        $data = new StdClass;
        $status = 400;

        //this is a test comment 

        if ($id){
            $userdata = User::where('id', $id)
                            ->update(['firstname' => $request->firstname, 'lastname' => $request->lastname, 'mobile' => $request->mobile ]); 
            $profile = Profile::where('user_id', $id)->first();
            if ($profile)
                $userProfileData = Profile::where('user_id', $id)->
                                        update([
                                                'dob' => $request->dob,
                                                'gender' => $request->gender,
                                                'profile_pic' => $request->profile_pic,
                                                'profession' => $request->profession
                                            ]);
           else 
                $userProfileData = Profile::where('user_id', $id)->
                                        insert([
                                                'dob' => $request->dob,
                                                'user_id' => $request->user()->id,
                                                'gender' => $request->gender,
                                                'profile_pic' => $request->profile_pic,
                                                'profession' => $request->profession
                                            ]);
            

           
           if ($userdata && $userProfileData){
                $response = new StdClass;
                $response->id = $request->id;
                $response->name = $request->name;
                $response->dob = $request->dob;
                $response->gender = $request->gender;
                $response->profile_pic = $request->profile_pic;
                $response->mobile = $request->mobile;
                $response->profession = $request->profession;
                $status = 200;
                $data->data = $response;
                $message = "Profile info saved";
           }

            else{
                $message = "Profile info not saved";
            }
            $data->status = $status;
            $data->message = $message;
        }
    return response()->json($data);
    }



    public function accountsetting(Request $request)
    {
        $id = $request->user()->id;
        $data = new StdClass;
        $data->status = 400;
        if ($id){
            $userdata = AccountSetting::where('user_id', $id)
                            ->first();             

            $data->accountsetting = $userdata;
            $data->status = 200;
        }
        return response()->json($data);
    }


    public function editaccountsetting(Request $request)
    {
        $id = $request->user()->id;
        $data = new StdClass;
        $status = 400;

        //this is a test comment 

        if ($id){

            $userdata = AccountSetting::where('user_id', $id)
                            ->first();
            if ($userdata){
                $userdata->booking_updates = $request->booking_updates;
                $userdata->email_updates = $request->email_updates;
                $userdata->sms_updates = $request->sms_updates;
                $userdata->update();
            }
            else
            {
                $userdata = new AccountSetting;
                $userdata->user_id = $id;
                $userdata->booking_updates = $request->booking_updates;
                $userdata->email_updates = $request->email_updates;
                $userdata->sms_updates = $request->sms_updates;
                $userdata->save();

            }
                          
           
           if ($userdata){
                $status = 200;
                $data->accountsetting = $userdata;
                $message = "Profile info saved";
           }

            else{
                $message = "Profile info not saved";
            }
            $data->status = $status;
            $data->message = $message;
        }
    return response()->json($data);
    }
}
