<?php

namespace App\Http\Responses\Backend\Liability;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Liability\Liability
     */
    protected $liabilities;

    /**
     * @param App\Models\Liability\Liability $liabilities
     */
    public function __construct($liabilities)
    {
        $this->liabilities = $liabilities;
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
        return view('backend.liabilities.edit')->with([
            'liabilities' => $this->liabilities
        ]);
    }
}