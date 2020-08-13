<?php

namespace App\Http\Responses\Backend\Masters;

use Illuminate\Contracts\Support\Responsable;

class ImportResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.masters.countries.import');
    }
}