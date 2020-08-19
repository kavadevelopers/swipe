<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Role;
use App\Brand;
use App\Carmodel;
use App\MyCar;
use App\OTP;
use App\WasherDetails;
use App\PaymentCard;
use App\Notifications;
use App\UserNotification;
use App\WasherBankDetail;
use App\Mail\PasswordResetOtp;
use Mail;
use Carbon\Carbon;
use StdClass;
use DB;
use Image;
use Stripe;
use Hash;
use File;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('display_name','id');
        return view('users.create',compact('roles')); //return the view with the list of roles passed as an array
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'roles' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password');
        $input['password'] = Hash::make($input['password']); //Hash password
        $user = User::create($input); //Create User table entry
        //Attach the selected Roles
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    public function editEmail(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $rules = [
            'email' => 'required',
        ];
        $validator = Validator::make([
            'email' => $request->email,
        ], $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> "Please validate before sending"],200);
        }
        $userId = $request->user()->id;
        $email_token = base64_encode($request->email);
        $user = User::where('id',$userId)->first(); //get User table entry
        if($user){
            $randphone = mt_rand(10000, 99999);
            $user->remember_token = $randphone;
            $message = "Your OTP is $randphone.Please use this to verify email.";
            try {
                $user->email = $request->email;
                $user->email_verified_at = null;
                Mail::to($request->email)->send(new PasswordResetOtp($message));
                $user->update();
                $message = "Email updated & send verification mail";
                $status = 200;
            } catch (\Throwable $th) {
                $message = "Something went wrong. Please try again after sometime";
                $status = 401;
                //throw $th;
            }
    
                
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }

    public function verifyEmailOtp(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $user = User::where('email',$request->email)->first();
        if ($user){
            if (isset($user->remember_token) && $request->otp == $user->remember_token){
                $user->email_verified_at = Carbon::now();
                $user->email_verification = 'Verified';
                $user->update();
                $status = 200;
                $message = "User Email verified";
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

    public function editMobileNumber(Request $request)
    {
        $rules = [
            'mobile' => 'required',
        ];
        $validator = Validator::make([
            'mobile' => $request->mobile,
        ], $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> "Please validate before sending"],200);
        }

        $userId = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->mobile;
        $user = User::where('id', $userId)->first();
        $randphone = mt_rand(10000, 99999);
        if($user){

            $mobile = $user->country_code.$request->mobile;
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
                $message = "Sms not sent";
                $status = 400;
            }else{
                curl_close($c);
                $message = "Sms sent";
                $status = 200;
            }
        }
        $response->status = $status;
        $response->otp = (string) $randphone;
        $response->message = $message;
        return response()->json($response);
    }

    public function verifyMobileOtp(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $user = User::where('id',$request->user()->id)->first();
        if ($user){
            if (isset($user->remember_token) && $request->otp == $user->remember_token){
                $user->mobile_verified_at = Carbon::now();
                $user->mobile_verification = 'Verified';
                $user->mobile = $request->mobile;
                $user->update();
                $status = 200;
                $message = "User mobile number changed";
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get(); //get all roles
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit',compact('user','roles','userRoles'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'roles' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password');
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']); //update the password
        }else{
            $input = array_except($input,array('password')); //remove password from the input array
        }
        $user = User::find($id);
        $user->update($input); //update the user info
        //delete all roles currently linked to this user
        DB::table('role_user')->where('user_id',$id)->delete();
        //attach the new roles to the user
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
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
            $user->name = $userdata->name;
            $user->verification_status = $userdata->verification_status;
            $user->email = $userdata->email;
            $userProfileData = Profile::with('PrimaryCar','PrimaryCard')->where('user_id', $id)->first();
            if(is_null($userProfileData)){
                User::where('id',$id)->update([ 'address' => $request->address ]);
                $profile = Profile::create(['user_id' => $id,'dob' => $request->dob,'gender' => $request->gender, 'profession' => $request->profession]);
                $userProfileData = Profile::with('PrimaryCar','PrimaryCard')->where('user_id', $id)->first();
            }
            $user->washer = WasherBankDetail::where('user_id',$id)->first();
            $car_brand_id = '';
            $car_model_id = '';
            if($userProfileData){
                $car_brand_id = $userProfileData->PrimaryCar ? $userProfileData->PrimaryCar->car_brand : '';
                $car_model_id = $userProfileData->PrimaryCar ? $userProfileData->PrimaryCar->car_model : '';
            }
            // dump($car_model_id);
            // dd($car_model_id);
            $brand = Brand::where('id',$car_brand_id)->first();
            $model = Carmodel::select('carmodels.*','carmodels.model_name' ,'vehical_types.partner_price','vehical_types.user_price')->where('carmodels.id',$car_model_id)->join('vehical_types', 'vehical_types.id', '=', 'carmodels.vehicletype_id')->first();
            $user->dob="";
            $user->gender="";
            $user->mobile = $userdata->mobile;
            $user->user_type = $userdata->user_type;
            $user->profession="";
            $user->profile_pic="";
            $user->country_code = $userdata->country_code;
            $user->email_verification = $userdata->email_verification;
            $user->mobile_verification = $userdata->mobile_verification;
            
            
            
            if ($userProfileData){
                if($userProfileData['PrimaryCar']){
                    $userProfileData['PrimaryCar']->car_brand_name = $brand ? $brand->brand_name : '';
                    $userProfileData['PrimaryCar']->car_model_name = $model ? $model->model_name : '';
                    $userProfileData['PrimaryCar']->user_price = $model ? $model->user_price : '';
                    $userProfileData['PrimaryCar']->partner_price = $model ? $model->partner_price : '';
                    $userProfileData['PrimaryCar']->car_brand_name = $userProfileData['PrimaryCar']->car_brand_name;
                    $userProfileData['PrimaryCar']->car_model_name = $userProfileData['PrimaryCar']->car_model_name;
                }
                $user->dob = $userProfileData->dob;
                $user->gender = $userProfileData->gender;
                $user->profile_pic = $userProfileData->profile_pic;
                $user->profession = $userProfileData->profession;
                $user->primary_car = $userProfileData->PrimaryCar;
                $user->primary_card = $userProfileData->PrimaryCard;
                $user->upvote_count = $userProfileData->upvote_count;
                $user->downvote_count = $userProfileData->downvote_count;
                if(is_null($userProfileData->customer_key)){
                    $customer = Stripe::customers()->create([
                        'name' => $request->user()->name,
                        'description' => 'test description',
                        'email' => $request->user()->email,
                        "address" => ["city" => "test", "country" => "IN", "line1" => "test", "line2" => "", "postal_code" => "361220", "state" => "GUJ"],
                    ]);
                    $userProfileData->customer_key = $customer['id'];
                    $userProfileData->save();
                }
                $user->customer_key = $userProfileData->customer_key;
            }else{
                $user->primary_car =  null;
                $user->primary_card = null;
                $user->upvote_count = 0;
                $user->downvote_count = 0;

            }
            if (!isset($user->profile_pic) || $user->profile_pic == ''){
                $user->profile_pic="/profile_pic/avtar_new.png";
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

        // \Log::info("This is a message from a controller");
        // \Log::info(print_r($request->toArray(), true));
        // \Log::info($user_id);
        //this is a test comment 
        $infoArr = array(
            'name' => $request->name, 
            'mobile' => $request->mobile, 
            'country_code' => $request->country_code
        );

        if($request->has('address')){
            $infoArr['address'] = $request->address;
        }
        if ($id){
            $userdata = User::where('id', $id)
                            ->update($infoArr); 


            if($request->file('profile_pic')){
                $profile_pic = $request->file('profile_pic');
                $path = public_path().'/profile_pic'.$id."/";
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $path = public_path();
                $filename = '/profile_pic'.$id."/".time() . '.' . $profile_pic->getClientOriginalExtension();
                Image::make($profile_pic)->resize(300, 300)->save(public_path($filename));

            }
            $profile = Profile::where('user_id', $id)->first();
            if ($profile){
                if (!isset($filename)){
                    $filename = $profile->profile_pic;
                }
                $userProfileData = Profile::where('user_id', $id)->
                update([
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'profile_pic' => $filename,
                    'profession' => $request->profession
                ]);
           } else{
               $userProfileData = Profile::where('user_id', $id)->
                insert([
                    'dob' => $request->dob,
                    'user_id' => $request->user()->id,
                    'gender' => $request->gender,
                    'profession' => $request->profession
                ]);
            }

           if ($userdata && $userProfileData){
                $response = new StdClass;
                $response->id = $id;
                $response->country_code = $request->country_code;
                $response->name = $request->name;
                $response->dob = $request->dob;
                $response->gender = $request->gender;
                $response->profile_pic = $request->profile_pic;
                $response->mobile = $request->mobile;
                $response->address = $request->address;
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

    public function viewmyprimary(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $user_id = $request->user()->id;
        $mycar = MyCar::join('carmodels', 'carmodels.id', '=', 'my_cars.car_model')->join('brands', 'brands.id', '=', 'my_cars.car_brand')->select('my_cars.id as car_id','my_cars.*', 'carmodels.*', 'brands.*')->where('my_cars.user_id', $user_id)->orderBy('my_cars.status', 'Desc')->first();
        if ($mycar){
            $status = 200;
            $message = 'Data Processed';
            $response->my_car = $mycar;
        }
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

    public function reset_password(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Please enter a valid email.";
        $email = $request->email;
        if ($email){
            $status = 200;
            $message = "Email Sent. Please check for further action";
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);

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


    public function notifications(Request $request)
    {

        $response = new StdClass;
        $status = 400;
        $message = "No New Notifications";
        // $common = Notifications::where('user_id', '')->get();
        // $personal = Notifications::where('user_id', $request->user()->id)->get();
        $userlast = UserNotification::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->first();
        if ($userlast){
            $notifs = Notifications::where('id', '>', $userlast->notification_id)->get();
        }
        else{
            $notifs = Notifications::all();

        }
        foreach ($notifs as $key => $value) {
            $addnotif = new UserNotification;
            $addnotif->user_id = $request->user()->id;
            $addnotif->notification_id = $value->id;
            $addnotif->save();
        }
        $userlast = UserNotification::leftJoin('notifications', 'notifications.id', '=', 'user_notifications.notification_id')->where('user_notifications.user_id', $request->user()->id)->whereNull('user_notifications.status')->get();

        if ($userlast){
            $message = "Notifications received";
            $status = 200;
            $response->notifications = $userlast;
        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }


    public function deletenotification(Request $request)
    {

        $response = new StdClass;
        $status = 400;
        $message = "No Notifications Deleted";
        $userlast = UserNotification::where('user_id', $request->user()->id)->where('notification_id', $request->notification_id)->first();
        if ($userlast){
            $userlast->status = "Deleted";
            $userlast->update();
            $message = "Notifications deleted";
            $status = 200;
            $response->notifications = $userlast;
        }
        else{
            $message = "Wrong Notification";

        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function deleteallnotification(Request $request)
    {

        $response = new StdClass;
        $status = 400;
        $message = "No Notifications Deleted";
        $userlast = UserNotification::where('user_id', $request->user()->id)->update(['status' => 'Deleted']);
        if ($userlast){
            $message = "Notifications deleted";
            $status = 200;
            $response->notifications = $userlast;
        }
        else{
            $message = "Wrong Notification";

        }
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }

    public function profilepic(Request $request)
    {
        $id = $request->user()->id;
        $data = new StdClass;
        $status = 400;

        // \Log::info("This is a message from a controller");
        // \Log::info(print_r($request->toArray(), true));
        // \Log::info($user_id);
        //this is a test comment 

        if ($id){
            if($request->file('profile_pic')){
                $profile_pic = $request->file('profile_pic');
                $path = public_path().'/profile_pic'.$id."/";
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $path = public_path();
                $filename = '/profile_pic'.$id."/".time() . '.' . $profile_pic->getClientOriginalExtension();
                Image::make($profile_pic)->resize(300, 300)->save(public_path($filename));

            }
            $profile = Profile::where('user_id', $id)->first();
            if ($profile){
                if (!isset($filename)){
                    $filename = $profile->profile_pic;
                }
                $userProfileData = Profile::where('user_id', $id)->
                update([
                    'profile_pic' => $filename,
                ]);
           }
           if ($userProfileData){
                // $response = new StdClass;
                $status = 200;
                // $data->data = $response;
                $message = "Profile Pic saved";
           }
            else{
                $message = "Profile Pic not saved";
            }
            $data->status = $status;
            $data->message = $message;
        }
        return response()->json($data);
    }



    public function sendOTP(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong";
        $id = $request->user()->id;
        $user = User::find($id);
        if ($user->email_verification != 'Verified'){
            $mobile = $user->mobile;
            if ($mobile){
                $randphone = rand(100000,999999);
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
            if ($request->otp ==$otp->otp){
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

    public function addMyCar(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $rules = [
            'brand_id'        => 'required',
            'model_id'        => 'required',
            'vehicle_no'      => 'required|unique:my_cars',
        ];
        $messages = [
            'unique' => 'Vehicle plate number already exist',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $dataArr = array(
            "car_brand"     => $request->brand_id,
            "car_model"     => $request->model_id,
            "user_id"       => $user_id,
            "status"        => $request->status,
            "vehicle_no"    => $request->vehicle_no,
            "color_name"    => $request->color_name,
            "color_code"    => $request->color_code,
        );

        $carmodel = Carmodel::where('id',$request->model_id)->first();
        $vehicalType  = \App\VehicalType::find($carmodel->vehicletype_id);
        $dataArr["partner_price"]    = $vehicalType->partner_price;
        $dataArr["user_price"]    = $vehicalType->user_price;

        $car = MyCar::where([
			['user_id', '=', $user_id],
			['primary', '=', true]
        ])->get();

        $hasCar = MyCar::where([
			['user_id', '=', $user_id]
        ])->get();

        $dataArr['primary'] = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);

		if($car && count($car) > 0 && $dataArr['primary'] == true){
            MyCar::where([
				['user_id', '=', $user_id],
				['primary', '=', true]
			])->update(['primary' => false]); 
			$dataArr['primary']        = true;        
        }elseif(count($hasCar) <= 0){
			$dataArr['primary']        = true;
        }

        if($request->car_image){
            $directoryName = '/car_image/'.$user_id;
           
            if(!is_dir(public_path($directoryName))){
                //Directory does not exist, so lets create it.
                $result = File::makeDirectory(public_path($directoryName), 0777, true, true);
            }
            $filename = $directoryName."/". time() . '.jpg' ;
            Image::make(file_get_contents($request->car_image))->save(public_path($filename));
            $dataArr['car_image'] = $filename;                
        }   
        $mycar = MyCar::create($dataArr);
        if ($mycar){
                $response->mycar = $mycar;
                $status = 200;
                $message = "Car information saved Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
 }

 public function editMyCar(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'brand_id'        => 'required',
            'model_id'        => 'required',
            ]);

        

        $mycar = MyCar::where('user_id', $user_id)->where('id', $request->car_id)->first();
        if ($mycar){
            $mycar->car_brand      = $request->brand_id;
            $mycar->car_model      = $request->model_id;
            $mycar->user_id        = $user_id;        
            $mycar->status        = $request->status;        
            $mycar->vehicle_no      = $request->vehicle_no;
            $mycar->color_name      = $request->color_name;
            $mycar->color_code     = $request->color_code;

            $car = MyCar::where([
                ['user_id', '=', $user_id],
                ['primary', '=', true]
            ])->get();
    
            $mycar->primary = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);
    
            if($car && count($car) > 0 && $mycar->primary == true){
                MyCar::where([
                    ['user_id', '=', $user_id],
                    ['primary', '=', true]
                ])->update(['primary' => false]); 
                $mycar->primary        = true;        
            }
    
            if($request->car_image){
                    $directoryName = '/car_image/'.$user_id;
                   
                    if(!is_dir(public_path($directoryName))){
                        //Directory does not exist, so lets create it.
                        $result = File::makeDirectory(public_path($directoryName), 0777, true, true);
                    }
                    $filename = $directoryName."/". time() . '.jpg' ;
                    Image::make(file_get_contents($request->car_image))->save(public_path($filename));
                    $mycar->car_image = $filename;                
                }   
            $mycar->update();
            }
            else{
                $message = "This car is not yours";
            }

        if ($mycar){
                $response->mycar = $mycar;
                $status = 200;
                $message = "Car information saved Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
 }  

    public function setPrimaryCar(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validator = Validator::make($request->all(), [
            'car_id'        => 'required',
            'primary'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $mycar = MyCar::where('user_id', $user_id)->where('id', $request->car_id)->first();
        if ($mycar){
            $mycar->user_id        = $user_id;
            $car = MyCar::where([
                ['user_id', '=', $user_id],
                ['primary', '=', true]
            ])->get();
            $mycar->primary = filter_var($request->primary, FILTER_VALIDATE_BOOLEAN);
            if($car && count($car) > 0 && $mycar->primary == true){
                MyCar::where([
                    ['user_id', '=', $user_id],
                    ['primary', '=', true]
                ])->update(['primary' => false]); 
                $mycar->primary        = true;        
            }
            $mycar->update();
        }
        else{
            $message = "This car is not yours";
        }

        if ($mycar){
            $response->mycar = $mycar;
            $status = 200;
            $message = "Successfully seted car as Primary";
        }

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
    }

 public function deleteMyCar(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        
        
        $mycar = MyCar::where('user_id', $user_id)->where('id', $request->car_id)->first();
		if($mycar){
			if($mycar->primary){
				$primaryCar = MyCar::where([
                    ['user_id', '=', $user_id],
                    ['primary', '!=', true]
                ])->orderBy('id')->first();
                if($primaryCar){
                    $primaryCar->primary = true;
                    $primaryCar->save();
                }
			}
			$mycar = $mycar->delete();
		}

        // $mycar = MyCar::where('user_id', $user_id)->where('id', $request->car_id)->delete();
        // $mycar->update();


        if ($mycar){
                $response->mycar = $mycar;
                $status = 200;
                $message = "Car information deleted Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
 }

 public function viewMycar(Request $request)
 {
    $response = new StdClass;
    $status = 400;
    $message = "Something Went Wrong!!!";
    $user_id = $request->user()->id;
    $mycar = MyCar::join('carmodels', 'carmodels.id', '=', 'my_cars.car_model')->join('brands', 'brands.id', '=', 'my_cars.car_brand')->join('vehical_types', 'vehical_types.id', '=', 'carmodels.vehicletype_id')->select('my_cars.id as car_id','my_cars.*', 'carmodels.*', 'brands.*','vehical_types.*')->where('my_cars.user_id', $user_id)->orderBy('my_cars.status', 'Desc')->get();
    if ($mycar){
        $status = 200;
        $message = 'Data Processed';
        $response->my_car = $mycar;
    }
    $response->status = $status;
    $response->message = $message;
    return response()->json($response);

 }

    public function washerRequest(Request $request)
    {
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $user_id = $request->user()->id;
        User::where('id',$request->user()->id)->update(['user_type'=>'washer','verification_status' => 0]);
        $washer = WasherDetails::where('user_id', $user_id)->first();
        if ($washer){
            $status = 200;
            $message = "Request Already Submitted";
        }
        else{
            $washer = new WasherDetails;
            $profile = Profile::where('user_id', $user_id)->first();
            if ($profile){
                $profile->dob == $request->dob;
                $profile->update(); 
            }
            else{
                $profile = new Profile;
                $profile->user_id = $user_id;
                $profile->dob = $request->dob;
                $profile->save();
            }


            $washer->requester_name = $request->requester_name;
            $washer->requester_email = $request->requester_email;
            $washer->requester_dob = $request->requester_dob;
            $washer->user_id = $user_id;
            $washer->requester_mobile = $request->requester_mobile;
            if($request->requester_front_pic){
                $directoryName = '/id_proof/'.$user_id;
               
                if(!is_dir($directoryName)){
                    //Directory does not exist, so lets create it.
                    $result = File::makeDirectory(public_path($directoryName), 0777, true, true);
                }
                $filename = $directoryName."/front". time() . '.jpg' ;
                Image::make(file_get_contents($request->requester_front_pic))->save(public_path($filename));
                $washer->requester_front_pic = $filename;                
            }

            if($request->requester_back_pic){
                $directoryName = '/id_proof/'.$user_id;
                if(!is_dir($directoryName)){
                    //Directory does not exist, so lets create it.
                    $result = File::makeDirectory(public_path($directoryName), 0777, true, true);
                }
                 $filename = $directoryName."/back". time() . '.jpg' ;
                Image::make(file_get_contents($request->requester_back_pic))->save(public_path($filename));
                $washer->requester_back_pic = $filename;                
            }
            $washer->save();
            $status = 200;
            $message = "Request Saved Successfully";
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);
    }

    public function editAddress(Request $request)
    {
        // $rules = [
        //     'address' => 'required',
        // ];
        // $validator = Validator::make([
        //     'address' => $request->address,
        // ], $rules);
        // if($validator->fails()) {
        //     return response()->json(['success'=> false, 'error'=> "Please Enter Address"],200);
        // }

        $userId = $request->user()->id;
        $response = new StdClass;
        $status = 200;
        $message = "Address Upadte";
        $address = $request->address;
        $user = User::where('id', $userId)->first();
        $user->address = $address;
        $user->user_type = "washer";
        $user->update(); 
        
        $response->status = $status;
        $response->message = $message;

        return response()->json($response);
    }
}
