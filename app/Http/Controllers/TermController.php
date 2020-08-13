<?php

namespace App\Http\Controllers;

use App\Privacy;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function showtnc()
    {
    	return view('terms_condn');
    }

    public function showprivacy()
    {
        $privacy = Privacy::where('id',1)->first();
    	return view('privacy', ['privacy' => $privacy]);
    }
}
