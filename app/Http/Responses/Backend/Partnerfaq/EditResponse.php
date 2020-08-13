<?php

namespace App\Http\Responses\Backend\Partnerfaq;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Partnerfaq\Partnerfaq
     */
    protected $partnerfaqs;

    /**
     * @param App\Models\Partnerfaq\Partnerfaq $partnerfaqs
     */
    public function __construct($partnerfaqs)
    {
        $this->partnerfaqs = $partnerfaqs;
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
        return view('backend.partnerfaqs.edit')->with([
            'partnerfaqs' => $this->partnerfaqs
        ]);
    }
}