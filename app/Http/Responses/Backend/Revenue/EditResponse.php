<?php

namespace App\Http\Responses\Backend\Revenue;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Revenue\Revenue
     */
    protected $revenues;

    /**
     * @param App\Models\Revenue\Revenue $revenues
     */
    public function __construct($revenues)
    {
        $this->revenues = $revenues;
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
        return view('backend.revenues.edit')->with([
            'revenues' => $this->revenues
        ]);
    }
}