<?php

namespace App\Http\Responses\Backend\PartnerRedemption;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PartnerRedemption\PartnerRedemption
     */
    protected $partnerredemptions;

    /**
     * @param App\Models\PartnerRedemption\PartnerRedemption $partnerredemptions
     */
    public function __construct($partnerredemptions)
    {
        $this->partnerredemptions = $partnerredemptions;
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
        return view('backend.partnerredemptions.edit')->with([
            'partnerredemptions' => $this->partnerredemptions
        ]);
    }
}