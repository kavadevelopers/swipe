<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentGatewayController extends Controller
{
    public function makepayment(Request $request)
    {
    	echo '<a href="'.url('/stripesuccess').'">Success</a><br>
				<a href="'.url('/stripefail').'">Failed</a>';
    }

    public function stripesuccess(Request $request)
    {
    	echo 'Payment Success';
    }

    public function stripefail(Request $request)
    {
    	echo 'Payment Failure';
    }
}
