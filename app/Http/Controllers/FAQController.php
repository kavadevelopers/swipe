<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FAQ;
use StdClass;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FAQ::all();
        return view('admin.faqlist', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addfaq');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
           
        ]);
        $faq = new FAQ;
        $faq->question      = $request->question;
        $faq->answer          = $request->answer;   
        $faq->save();

        return redirect()->Route('faqs.index')->with('message', "Data Successfully Inserted");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $faq = FAQ::where('id', $id)->first();
        return view('admin.addfaq', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            
        ]);
        $faq = FAQ::find($id);
        $faq->question      = $request->question;
        $faq->answer          = $request->answer;        
        $faq->update();

        return redirect()->Route('faqs.index')->with('message', "Data Successfully Updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $FAQ = FAQ::find($id);
        $FAQ->delete();
        return redirect()->Route('faqs.index')->with('message', "Data Successfully Deleted");
        
    }

    public function getFAQ(Request $request)
    {
    	$id = $request->faq_id;
    	if ($id > 0)
    	{
    		$faq = FAQ::where('id', $id)
                            // ->where('status', 1)
    						->get();

    	}
    	else{
    		$faq = FAQ::all();
    		
    	}

    	$data = new StdClass;
    	$message = 'Data retrieved successfully';
    	$data->faq = $faq;
    	$data->status = 200;
    	$data->message = $message;

    	return response()->json($data);
    }
}
