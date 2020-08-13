<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Hash, StdClass, Mail;
use App\User;
use App\Vehicle;
use App\Complaint;
use App\requests;
use App\callbacks;
use App\contacts;
use App\WasherDetails;
use App\services;
use App\Ondemand;
use App\feedbacks;
use App\Mail\CarWashPaymentMail;
use App\slider_images;
use App\CarWashService;
use App\PopupSignup;
use App\Brand;
use App\Carmodel;
use App\Package;

class AdminController extends Controller
{
    public function showhome(Request $request)
    {
    	return view('admin.home');
    }

    public function template(Request $request)
    {
    	return view('admin.template');
    }

    public function showvehiclelist(Request $request)
    {
    
    	$vehicles = Vehicle::where('status', '1')
    						->select('vehicle_type','description','icon','rate')
    						->get();

    	return view('admin.view_vehicle_type', ['vehicles' => $vehicles]);

    
    }



    public function complain()
    {
        $complains = Complaint::all();
        return view('admin.complains', compact('complains'));
    }

    public function request()
    {
        $requests=requests::all();
        return view('admin.requests', compact('requests'));
    }

    public function callback()
    {
        $callbacks=callbacks::all();
        return view('admin.callbacks', compact('callbacks'));
    }
    public function ondemand()
    {
        $ondemands=Ondemand::all();
        return view('admin.ondemand', compact('ondemands'));
    }

    public function contact()
    {
        $contacts=contacts::all();
        return view('admin.contacts', compact('contacts'));
    }

    public function service()
    {
        $services=services::all();
        return view('admin.services', compact('services'));

    }

    public function feedback()
    {
        $feedbacks=feedbacks::all();
        return view('admin.feedbacks', compact('feedbacks'));

    }

    public function slider_image()
    {
      $slider_images=slider_images::all();
      return view('admin.slider_images', compact('slider_images'));   
    }

    public function userlist()
    {
        $userlists = User::select('name','mobile','email', 'created_at')->get();
        
        
        return view('admin.userlist', compact('userlists'));  
    }

    public function washerlist()
    {
        $washerdetails = WasherDetails::join('users', 'users.id', '=', 'washer_details.user_id')->select('users.name','users.mobile','users.email', 'users.created_at', 'washer_details.*')->get();
       
        
        
        return view('admin.washerlist', compact('washerdetails'));  
    }

    public function complain_destroy(){
        $complain = Complain::find($id);
        $complain->delete();
        return redirect()->Route('admin.complains')->with('message', "Data Successfully Deleted");
    }



     public function model_data($brand_id){

        // $brands = Brand::all();
        $data = Carmodel::where('brand_id',$brand_id)->get();
        // dd($data);
        return view('admin/model_data',compact('data'));

            }


    public function showcarwashbookingform(Request $request)
    {
        $User      = User::all();
        $Brand      = Brand::all();
        $Package        = Package::all();
        $Carmodel       = Carmodel::all();

        $users = array("0" => "select" );
        foreach ($User as $key => $value) {
            $id = $value->id;
            $users[$id] = $value->firstname." ".$value->lastname."(".$value->id.")";
        }


        $carmodels = array();
        foreach ($Carmodel as $key => $value) {
            $id = $value->id;
            $carmodels[$id] = $value->model_name;
        }

        $brands = array();
        foreach ($Brand as $key => $value) {
            $id = $value->id;
            $brands[$id] = $value->brand_name;
        }

        $packages = array();
        foreach ($Package as $key => $value) {
            $id = $value->id;
            $packages[$id] = $value->package_name;
        }

        return view('admin.add_booking', compact('brands', 'carmodels', 'packages', 'users'));
    }

    public function savecarwashrequest(Request $request)
    {
        $user_id = $request->user_id;

        if (!isset($user_id) || $user_id == 0){
            $user = new User;
            $user->firstname    = $request->firstname;
            $user->lastname     = $request->lastname;
            $user->email    = $request->email;
            $user->mobile   = $request->mobile;
            $user->user_type   = 'user';
            $user->password = Hash::make($request->mobile);
            $user->email_token = base64_encode($request->email);
            $user->save();
            $user_id = $user->id;
        }
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'brand_id'        => 'required',
            'model_id'        => 'required',
            'car_type'        => 'required',   
            'package_id'      => 'required',            
                        
        ]);

        

        $washrequest = new CarWashService;
        $washrequest->brand_id      = $request->brand_id;
        $washrequest->model_id      = $request->model_id;
        $washrequest->car_type      = $request->car_type;
        $washrequest->user_id      = $user_id;
        $washrequest->package_id      = $request->package_id;        
        $washrequest->save();

        $user = User::where('id', $user_id)->first();
 
        // Mail::to($user->email)->send(new CarWashPaymentMail($user, $washrequest->id));


        return redirect('/admin/userlists');
    }

    public function showsendsms(Request $request)
    {
        return view('admin.sendsms');
    }

    public function sendsms(Request $request)
    {
        $no = $request->cellno;
        $sms = $request->sms;
        $sms = str_replace(' ', '%20', $sms);
        $url = "http://103.16.101.52:8080/sendsms/bulksms?username=bcks-imzhnd&password=Super123&type=0&dlr=1&destination=$no&source=BSSPLI&message='$sms'";
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

           return redirect('/admin/sendsms');
    }

    public function pendingorder(Request $request)
    {
        $carwasherequest = CarWashService::join('brands', 'brands.id', '=', 'car_wash_services.brand_id')->join('carmodels', 'carmodels.id', '=', 'model_id')->join('packages', 'packages.id', '=', 'package_id')->join('users', 'users.id', '=', 'user_id')->select('packages.package_name', 'packages.package_price', 'packages.package_category', 'car_wash_services.car_type', 'car_wash_services.payment_status', 'users.firstname','users.mobile', 'car_wash_services.created_at')->get();
        return view('admin.pendingorders', compact('carwasherequest'));
    }
}
