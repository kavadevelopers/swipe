<?php

namespace App\Http\Responses\Backend\PartnerPricing;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PartnerPricing\PartnerPricing
     */
    protected $partnerpricings;

    /**
     * @param App\Models\PartnerPricing\PartnerPricing $partnerpricings
     */
    public function __construct($partnerpricings)
    {
        $this->partnerpricings = $partnerpricings;
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
        return view('backend.partnerpricings.edit')->with([
            'partnerpricings' => $this->partnerpricings
        ]);
    }
}