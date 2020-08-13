<?php

namespace App\Http\Responses\Backend\LoudHailer;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\LoudHailer\LoudHailer
     */
    protected $loudhailers;

    /**
     * @param App\Models\LoudHailer\LoudHailer $loudhailers
     */
    public function __construct($loudhailers)
    {
        $this->loudhailers = $loudhailers;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.loudhailers.edit')->with([
            'loudhailers' => $this->loudhailers
        ]);
    }
}