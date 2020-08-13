<?php

namespace App\Http\Responses\Backend\UserPricing;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\UserPricing\UserPricing
     */
    protected $userpricings;

    /**
     * @param App\Models\UserPricing\UserPricing $userpricings
     */
    public function __construct($userpricings)
    {
        $this->userpricings = $userpricings;
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
        return view('backend.userpricings.edit')->with([
            'userpricings' => $this->userpricings
        ]);
    }
}