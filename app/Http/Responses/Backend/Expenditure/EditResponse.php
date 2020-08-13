<?php

namespace App\Http\Responses\Backend\Expenditure;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Expenditure\Expenditure
     */
    protected $expenditures;

    /**
     * @param App\Models\Expenditure\Expenditure $expenditures
     */
    public function __construct($expenditures)
    {
        $this->expenditures = $expenditures;
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
        return view('backend.expenditures.edit')->with([
            'expenditures' => $this->expenditures
        ]);
    }
}