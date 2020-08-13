<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StdClass;

class BankController extends Controller
{
    public function banklist(Request $request)
    {
    	$response = new StdClass;
    	$status = 400;
    	$banks = array();
    	for ($i=0; $i < 6; $i++) { 
    		$bank = new StdClass;
    		$bank->bank_name = "Bank ".$i;
    		array_push($banks, $bank);
    	}
    	$status = 200;
		$response->banks = $banks;
		$response->status = $status;
		$response->message = "Data retrieved successfully";
		return response()->json($response);
    }
}
