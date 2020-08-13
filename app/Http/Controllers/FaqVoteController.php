<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use DB;
class FaqVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $faq = DB::table('faqs as f')
        ->select('id','question','answer','upvote','downvote',
            DB::raw('(select count(*) from user_faq_votes where user_id='.$request->user()->id.' AND f.id=user_faq_votes.question_id) AS is_voted'))
            ->get();
            return response()->json($faq);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data =  array(
            'user_id' => $request->user()->id, 'question_id' => $request->question_id
       );
       $faq = Faq::where('id',$request->question_id)->first();
       switch ($request->vote) {
           case 'up':
            $data['upvote'] = 1;
            $faq->upvote = $faq->upvote +1;
            break;
            case 'down':
            $data['downvote'] = 1;
            $faq->downvote = $faq->downvote +1;
            break;
       }
        $faq->save();
        DB::table('user_faq_votes')->insert($data);
        return response()->json($faq);

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
