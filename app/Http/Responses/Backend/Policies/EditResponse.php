<?php

namespace App\Http\Responses\Backend\Policies;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Policies\Policy
     */
    protected $policies;

    /**
     * @param App\Models\Policies\Policy $policies
     */
    public function __construct($policies)
    {
        $this->policies = $policies;
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
        return view('backend.policies.edit')->with([
            'policies' => $this->policies
        ]);
    }
}