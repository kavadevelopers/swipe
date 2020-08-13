<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StdClass;
use DB;

class ApiVehicleColor extends Controller
{
    public function get_colors()
    {
    	$list = DB::table('vehicle_colors')->get();
    	$data = new StdClass;
    	$message = 'Data retrieved successfully';
    	$data->colors = $list;
    	$data->status = 200;
    	$data->message = $message;

    	return response()->json($data);
    }
}
