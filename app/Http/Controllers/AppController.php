<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StdClass;
use App\Brand;
use App\Carmodel;
use App\Carwashrequest;
use App\wallet_transaction;
use App\CarWashService;
use App\Complaint;
use App\Package;
use App\Serviceenquiry;

class AppController extends Controller
{
    

// =================== Get Brand =================

    public function getBrand(Request $request)
    {
        $id = $request->brand_id;
    	if ($id)
    	{
    		$brands = Brand::where('id', $id)
                            // ->where('status', 1)
    						->get();

    	}
    	else{
    		$brands = Brand::all();
    		
    	}

    	$data = new StdClass;
    	$message = 'Data retrieved successfully';
    	$data->brands = $brands;
    	$data->status = 200;
    	$data->message = $message;

    	return response()->json($data);
    }


// ================ get Model =================

    public function getModel(Request $request)
    {
    	$brand_id = $request->brand_id;

    	$response = new StdClass;
    	$status = 400;
    	$message = "Data not found";
    	$models = Carmodel::where('brand_id', $brand_id)->get();
    	if ($models){
    		$response->models = $models;
    		$status = 200;
    		$message = 'Data retrieved successfully';

    	}

    	$response->status = $status;
    	$response->message = $message;
    	return response()->json($response);

    }



 // ================ Car Wash Request ==================
 

 public function carWashrequest(Request $request){

	 	$response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'brand_id'        => 'required',
            'model_id'       => 'required',
            'car_type'   => 'required',
            'name'  => 'required',
            'mobile'   => 'required',            
            'city'     => 'required',            
            'locality'       => 'required',            
            'apartment'      => 'required',            
            'address'      => 'required'            
        ]);

        $washrequest = new Carwashrequest;
        $washrequest->brand_id      = $request->brand_id;
        $washrequest->model_id      = $request->model_id;
        $washrequest->car_type      = $request->car_type;
        $washrequest->name      = $request->name;
        $washrequest->mobile      = $request->mobile;
        $washrequest->city      = $request->city;
        $washrequest->locality      = $request->locality;
        $washrequest->apartment      = $request->apartment;
        $washrequest->address      = $request->address;
        $washrequest->save();

        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $model_form_data = Carmodel::where('brand_id',$brand_id)
                    ->where('id',$model_id)
                    ->first();  
        if (isset($model_form_data)){
            $type = $model_form_data->type;

            $packageFormdata = Package::where('package_category',$type)
                                     ->get();           


            if ($washrequest){
                    $response->washrequest = $washrequest;
                    $response->package_available = $packageFormdata;
                    $status = 200;
                    $message = "Request Submitted Successfully";

            }
        }
        else{
            $message = 'Wrong model';
        }   

        $response->status = $status;
    	$response->message = $message;
    	return response()->json($response);     
 }   
 public function get_package(Request $request)
 {
    $response = new StdClass;
    $status = 400;
    $message = "Something Went Wrong!!!";
     $user_id = $request->user()->id;
     $package_id = $request->package_id;
     $package = Package::where('id', $package_id)->first();

     if ($user_id)
        {
            $credit = wallet_transaction::where('user_id', $user_id)
                                    ->where('transaction_type', 'credit')
                                    ->sum('amount');
            $debit = wallet_transaction::where('user_id', $user_id)
                                    ->where('transaction_type', 'debit')
                                    ->sum('amount');
            $amount = $credit - $debit;
            
        }
        else{
            $amount = 0;
        }
        if ($amount>=$package->package_price){
            $amount_payable = 0;
            $Transaction = new wallet_transaction();
            $Transaction->user_id               = $user_id;
            $Transaction->amount                = $package->package_price;
            $Transaction->transaction_type      = "debit";
            $Transaction->status                = 1;
            $Transaction->date                  = $date;
            $Transaction->sent_to               = '9999999';
            $Transaction->save();
        }
        else{
            $amount_payable = $package->package_price - $amount;
            $wallet_amount = $package->package_price-$amount_payable;
            if ($wallet_amount>0){
                $Transaction = new wallet_transaction();
                $Transaction->user_id               = $user_id;
                $Transaction->amount                = $wallet_amount;
                $Transaction->transaction_type      = "debit";
                $Transaction->status                = 1;
                $Transaction->date                  = $date;
                $Transaction->sent_to               = '9999999';
                $Transaction->save();
            }
        }
        $package->amount_payable = $amount_payable;
        if ($amount_payable){
            $status = 200;
            $message = 'Data Processed';
            $response->package = $package;
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);

 }


 public function get_packages(Request $request)
 {
    $response = new StdClass;
    $status = 400;
    $message = "Something Went Wrong!!!";
    if (isset($request->user()->id))
        $user_id = $request->user()->id;
    $brand_id = $request->brand_id;
    $model_id = $request->model_id;
    $model_data = Carmodel::where('brand_id',$brand_id)
                    ->where('id',$model_id)
                    ->first();  
    if (isset($model_data->type)){                
        $type = $model_data->type;

        $package = Package::where('package_category',$type)
                                      ->get();;

        
            
       if ($package){
            $status = 200;
            $message = 'Data Processed';
            $response->package = $package;
        }
        }
        else{
                $status = 200;
                $message = 'model not found';
            
        }
        $response->status = $status;
        $response->message = $message;
        return response()->json($response);

 }



 // ==================== carwash request create ================= 


 public function carWashrequestcreate(Request $request){
        $user_id = $request->user()->id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([            
            'payu_payment_id'=> 'required',            
            'payment_status'  => 'required',            
            'paid_amount'     => 'required',            
            'used_wallet_balance'=> 'required',            
        ]);

        $count = $request->carcount;

        for ($i=1; $i <= $count; $i++) { 
            # code...

        

        $washrequest = new CarWashService;
        $brandvariable = 'brand_id'.$i;
        $washrequest->brand_id      = $request->$brandvariable;
        $modelvariable = 'model_id'.$i;
        $washrequest->model_id      = $request->$modelvariable;
        $car_typevariable = 'car_type'.$i;
        $washrequest->car_type      = $request->$car_typevariable;
        $washrequest->user_id      = $user_id;
        $packagevariable = 'package_id'.$i;
        $washrequest->package_id      = $request->$packagevariable;
        $washrequest->paytm_payment_id      = $request->payu_payment_id;
        $washrequest->payment_status      = $request->payment_status;
        $washrequest->paid_amount      = $request->paid_amount;
        $washrequest->gateway      = $request->gateway;
        $washrequest->used_wallet_balance      = $request->used_wallet_balance;
                $washrequest->save();
        }


        if ($washrequest){
                $response->washrequest = $washrequest;
                $status = 200;
                $message = "Request Submitted Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);     
 }


 public function carWashrequestcreate1(Request $request){
        $user_id = $request->user()->id;
	 	$response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        

        $count = $request->carcount;

        for ($i=1; $i <= $count; $i++) { 
            # code...

        

        $washrequest = new CarWashService;
        $brandvariable = 'brand_id'.$i;
        $washrequest->brand_id      = $request->$brandvariable;
        $modelvariable = 'model_id'.$i;
        $washrequest->model_id      = $request->$modelvariable;
        $car_typevariable = 'car_type'.$i;
        $washrequest->car_type      = $request->$car_typevariable;
        $washrequest->user_id      = $user_id;
        $packagevariable = 'package_id'.$i;
        $washrequest->package_id      = $request->$packagevariable;
        $washrequest->paytm_payment_id      = $request->payu_payment_id;
        $washrequest->payment_status      = $request->payment_status;
        $washrequest->paid_amount      = $request->paid_amount;
        $washrequest->gateway      = $request->gateway;
        $washrequest->used_wallet_balance      = $request->used_wallet_balance;
                $washrequest->save();
        }


        if ($washrequest){
                $response->washrequest = $washrequest;
                $status = 200;
                $message = "Request Submitted Successfully";

        }   

        $response->status = $status;
    	$response->message = $message;
    	return response()->json($response);     
 }  


    public function getCarWashPrice(Request $request)
    {
        $car_id = $request->car_id;
        $response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $price = 20;
        if ($price){
            $response->price = $price;
            $status = 200;
            $message = "Price Retrieved Successfully";

        }   

        $response->status = $status;
        $response->message = $message;
        return response()->json($response);  

 }

// ================== service enquiry ==================



 public function serviceEnquiry(Request $request){

	 	$response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'service_id'        => 'required',
            'brand_id'        => 'required',
            'model_id'       => 'required',
            'service_desc'   => 'required'           
        ]);

        $service_enquiry = new Serviceenquiry;
        $service_enquiry->service_id      = $request->service_id;
        $service_enquiry->brand_id      = $request->brand_id;
        $service_enquiry->model_id      = $request->model_id;
        $service_enquiry->name      = $request->name;
        $service_enquiry->mobile      = $request->mobile;
        $service_enquiry->enquiry_type      = $request->enquiry_type;
        $service_enquiry->image_id      = $request->image_id;
        $service_enquiry->service_desc      = $request->service_desc;
        $service_enquiry->save();


        if ($service_enquiry){
                $response->service_enquiry = $service_enquiry;
                $status = 200;
                $message = "Request Submitted Successfully";

        }   

        $response->status = $status;
    	$response->message = $message;
    	return response()->json($response);     
 }  



// =================== complaint ====================


 public function Complaintraise(Request $request){

	 	$response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'complaint'        => 'required'           
        ]);

        $complaint = new Complaint;
        $complaint->user_id        	= $request->user()->id;
        $complaint->complaint      = $request->complaint;
        $complaint->save();


        if ($complaint){
                $response->complaint = $complaint;
                $status = 200;
                $message = "Complaint Submitted Successfully";

        }   

        $response->status = $status;
    	$response->message = $message;
    	return response()->json($response);     
 } 




// ========================== support ======================

  public function Support(Request $request){

	 	$response = new StdClass;
        $status = 400;
        $message = "Something Went Wrong!!!";
        $validatedData = $request->validate([
            'support'        => 'required'           
        ]);

        $support = new Support;
        $support->user_id        	= $request->user()->id;
        $support->support      = $request->support;
        $support->save();


        if ($support){
                $response->support = $support;
                $status = 200;
                $message = "Support Submitted Successfully";

        }   

        $response->status = $status;
    	$response->message = $message;
    	return response()->json($response);     
 }  








}
