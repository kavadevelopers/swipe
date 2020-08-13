<?php

namespace App\Http\Responses\Backend\PromoCodes;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PromoCodes\PromoCode
     */
    protected $promocodes;

    /**
     * @param App\Models\PromoCodes\PromoCode $promocodes
     */
    public function __construct($promocodes)
    {
        $this->promocodes = $promocodes;
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
        return view('backend.promocodes.edit')->with([
            'promocodes' => $this->promocodes
        ]);
    }
}