<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Profile;
use App\PushNotification;
use App\OTP;
use App\Mail\PasswordResetOtp;
use JWTFactory;
use JWTAuth;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail, Illuminate\Support\Facades\Password, StdClass;
// use Illuminate\Auth\Events\Registered;
// use App\Jobs\SignupMail;
// use App\Jobs\SendVerificationEmail;
use Carbon\Carbon;

class AuthApiController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */


    public function register(Request $request)
    {
        $credentials = $request->only('name', 'mobile',  'email', 'password');
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'mobile' => 'required|unique:users',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $mobile = $request->mobile;
        $email_token = base64_encode($request->email);
        $user = User::create(['email' => $email, 'name' => $name, 'mobile' => $mobile, 'password' => Hash::make($password), 'admin_id' => null]);
        $profile = Profile::create(['user_id' => $user->id,'dob' => $request->dob,'gender' => $request->gender, 'profession' => $request->profession]);
        $user->sendEmailVerificationNotification();
        return response()->json(['success' => true, 'error' => 'Successfully registerd,Please verify your email and then try to login'], 200);
        // return $this->login($request);
    }



    public function verifyPasswordResetOtp(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $user = User::where('email',$request->email)->first();
        if ($user){
            if (isset($user->remember_token) && $request->otp == $user->remember_token){
                $status = 200;
                $message = "Otp verified";
            }
            else {
                $status = 200;
                $message = "Otp Missmatch";
            }
        }
        else {
            $status = 200;
            $message = "User Not Found";
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'user_type' => 'rider',
        ];
        $validator = Validator::make([
            'email' => $request->email,
            'password' => $request->password
            ], $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> "Please validate before sending"],200);
        }
        $user = User::where('email', $request->email)->first();
        try {
            // attempt to verify the credentials and create a token for the user
            if($user && $user->provider == null && !$user->email_verified_at){
                $user->sendEmailVerificationNotification();
                return response()->json(['success' => false, 'error' => 'Please verify your email first'], 200);
            }
            if (!$token = JWTAuth::attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ])) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 200);
            }
            $userStatus = "";
            $userPaymentStatus = "";
            if($user && $user->status == "0"){
                $user->status = "pending";
            }elseif($user && $user->status == "1"){
                $user->status = "approve";
            }else{
                $$user->status = "reject";
            }

            if($user && $user->payment_status == "0"){
                $user->payment_status = "pending";
            }elseif($user->payment_status == "1"){
                $user->payment_status = "paid";
            }else{
                $user->payment_status = "reject";
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 200);
        }
        // all good so return the token
       
        if ($request->device_token){
            $user->device_token = $request->device_token;
            $user->email_verification = 'Verified';
            $user->update();
        }
       $push =  PushNotification::where('user_id',$user->id)->first();
       if($push != null){
           $user->notification_token = $push->notification_token;
       }
        return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $user]]);
    }

    public function googleloginfun(Request $request)
    {
        $credentials = $request->only('name', 'mobile',  'email', 'provider_id');
        $idTokenString = $request->provider_id;
        // $user = app('firebase.auth')->verifyIdToken($idTokenString);
        // dd($user);
        // $user = User::where('provider_id', $request->provider_id)->first();
        $user = User::where('email', $request->email)->first();
        // // $password = 'password123';
        $provider = $request->provider;
        if ($user){
            $user->provider_id = $request->provider_id;
            $user->provider = $provider;
            $user->update();

            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['success' => false, 'error' => 'We cant  an account with this credentials.'], 200);
            }
            else{
                return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $user]]);
            }
        }
        else{
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'provider_id' => 'required|max:255'
        ];
        $validator = Validator::make($credentials, $rules);
        $user = User::where('email', $request->email)->where('provider_id', $request->provider_id)->first();
        if(isset($user) && $token = JWTAuth::fromUser($user)){
            return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $user]]);
            // return response()->json(['success' => true, 'data'=> [ 'token' => $token]]);    
        }
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'provider_id' => 'required|max:255'
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        if (!isset($user) || !$token = JWTAuth::fromUser($user)) {
            $name = $request->name;
            $email = $request->email;
            $password = str_random(10);
            $mobile = $request->mobile;
            $provider_id = $request->provider_id;
            $user = User::create([
                'email' => $email,
                'provider_id' => $provider_id,
                'provider' => $provider ,
                'name' => $name,
                'mobile' => $mobile,
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now(),
            ]);
            if (!$token = JWTAuth::attempt([
                                        'email' => $request->email,
                                        'password' => $password
                                        ])) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 200);
            }
            else{
                return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $user]]);
                
                // return response()->json(['success' => true, 'data'=> [ 'token' => $token]]);    
            }
            
            return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 200);
        }        
        return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $user]]);

        // return response()->json(['success' => true, 'data'=> [ 'token' => $token]]);    
        }
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        $os = $request->os;
        $user_id = $request->user_id ??$request->user()->id;
        $push =  PushNotification::where('os',$os)
        ->where('user_id',$user_id)
        ->delete(); 
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 200);
        }
    }


    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 200);
        }
        try {
            $user->remember_token = '123456';
            $user->update();
            // Password::sendResetLink($request->only('email'), function (Message $message) {
            //     $message->subject('Your Password Reset Link');
            // });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 200);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    public function change_password(Request $request)
    {

        $response = new StdClass;
        $status = 400;
        $message = "Password not matched";
        $id = $request->user()->id;
        if (!(Hash::check($request->old_password, $request->user()->password))) {
            // The passwords matches
            $message = "Your current password does not matches with the password you provided. Please try again.";
        }
        if(strcmp($request->old_password, $request->new_password) == 0){
            //Current password and new password are same
            $message = "New Password cannot be same as your current password. Please choose a different password.";
        }
        $validatedData = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required',
        ]);
        //Change Password
        $user = $request->user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        if ($user){
            $status = 200;
            $message = "Password changed successfully";
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);

    }

    public function passowordsendOTP(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->mobile;
        $user = User::where('mobile', $id)->first();
        if($user){

            $mobile = $user->country_code.$user->mobile;
            $randphone = mt_rand(10000, 99999);
            $user->remember_token = $randphone;
            $user->update(); 
            $message = "Your%20OTP%20is%20$randphone.%20Please%20use%20this%20otp%20to%20reset%20your%20password.";
            $url = "http://103.16.101.52:8080/sendsms/bulksms?username=bcks-imzhnd&password=Super123&type=0&dlr=1&destination=$mobile&source=BSSPLI&message=$message";
             $c = curl_init();
             curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
             curl_setopt($c,CURLOPT_HTTPGET ,1);
             
             curl_setopt($c, CURLOPT_URL, $url);
             $contents = curl_exec($c);
               if (curl_errno($c)) {
                 echo 'Curl error: ' . curl_error($c);
               }else{
                 curl_close($c);
               }
    
           $message = "Sms sent";
           $status = 200;
    
                
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }

    public function passowordResetMail(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->email;
        $user = User::where('email', $id)->first();
        if($user){
            $randphone = mt_rand(10000, 99999);
            $user->remember_token = $randphone;
            $user->update(); 
            $messagea = "Your OTP is $randphone.Please use this otp to reset your password.";
            try {
                //code...
                Mail::send(array(), array(), function ($message) use ($messagea,$id) {
                  $message->to($id)
                    ->subject("OTP Password reset")
                    ->setBody($messagea, 'text/html');
                });

                $message = "Mail sent";
                $status = 200;
            } catch (\Exception $th) {
                $message = "Something went wrong. Please try again after sometime";
                //$message = $th->getMessage();
                $status = 401;
                //throw $th;
            }
    
                
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }



    public function sendOTP(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->user()->id;
        $user = User::find($id);
        if ($user->mobile_verification != 'Verified'){
            $mobile = $user->mobile;
            if ($mobile){
                $randphone = '123456';
                // $randphone = rand(100000,999999);
                $otp = new OTP;
                $otp->user_id = $id;
                $otp->otp = $randphone;
                $otp->save();
                $message = "Your%20OTP%20is%20$randphone.%20Please%20use%20this%20otp%20to%20verify%20your%20account.";
                $url = "http://103.16.101.52:8080/sendsms/bulksms?username=bcks-imzhnd&password=Super123&type=0&dlr=1&destination=$mobile&source=BSSPLI&message='$message'";
                 $c = curl_init();
                 curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
                 curl_setopt($c,CURLOPT_HTTPGET ,1);
                 
                 curl_setopt($c, CURLOPT_URL, $url);
                 $contents = curl_exec($c);
                   if (curl_errno($c)) {
                     echo 'Curl error: ' . curl_error($c);
                   }else{
                     curl_close($c);
                   }

                   $message = "Sms sent";
                   $status = 200;

            }
            else {
                $message = "No number found";
                $status = 200;
            }

        }
        else {
            $message = "Already Verified";
            $status = 200;
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }



    public function validateOTP(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->user()->id;
        $user = User::find($id);
        if ($user){
            $otp = OTP::where('user_id', $id)->orderBy('id', 'DESC')->first();
            if (isset($request->otp) && isset($otp->otp) && $request->otp == $otp->otp){
                $user->mobile_verification = "Verified";
                $user->update();
                $status = 200;
                $message = "Otp verified";

            }
            else {
                $status = 200;
                $message = "Otp Missmatch";
            }
        }
        else {
            $status = 200;
            $message = "User Not Found";
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    } 

    public function validatechangeOTP(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->email;
        $user = User::where('email', $id)->first();
        if ($user){
            if (!is_null($user->remember_token) && $user->remember_token == $request->otp){
                $user->remember_token = null;
                $user->password = Hash::make($request->password);
                $user->update();
                $status = 200;
                $message = "Password Changed";
            }
            else {
                $message = "Otp Missmatch";
            }
        }
        else {
            $message = "User Not Found";
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }
}